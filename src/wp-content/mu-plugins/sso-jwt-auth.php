<?php
/**
 * Plugin Name: SSO JWT Auth
 * Description: Intercepte le cookie JWT posé par le microservice SSO sur *.esthima.fr
 *              et connecte/crée automatiquement l'utilisateur WordPress correspondant.
 * Version:     1.0.0
 */

if (!defined('ABSPATH')) exit;

// ---------------------------------------------------------------------------
// Configuration
// Surcharger dans wp-config.php si besoin :
//   define('SSO_JWT_SECRET',        'votre_secret_hmac_partage');
//   define('SSO_JWT_COOKIE_NAME',   'jwt_token');         // nom du cookie posé par le MS
//   define('SSO_JWT_COOKIE_DOMAIN', '.esthima.fr');       // domaine wildcard
//   define('SSO_JWT_DEFAULT_ROLE',  'customer');          // rôle WP à la création
// ---------------------------------------------------------------------------

if (!defined('SSO_JWT_COOKIE_NAME'))   define('SSO_JWT_COOKIE_NAME',   'jwt_token');
if (!defined('SSO_JWT_COOKIE_DOMAIN')) define('SSO_JWT_COOKIE_DOMAIN', '.esthima.fr');
if (!defined('SSO_JWT_DEFAULT_ROLE'))  define('SSO_JWT_DEFAULT_ROLE',  'customer');
if (!defined('SSO_JWT_DEBUG'))         define('SSO_JWT_DEBUG',         false);

function sso_log(string $level, string $message): void
{
    if (!SSO_JWT_DEBUG) {
        return;
    }
    $prefix = $level === 'debug' ? '[SSO-JWT][debug]' : '[SSO-JWT]';
    error_log("{$prefix} {$message}");
}

function sso_base64url_decode(string $input): string
{
    $remainder = strlen($input) % 4;
    if ($remainder !== 0) {
        $input .= str_repeat('=', 4 - $remainder);
    }
    return base64_decode(strtr($input, '-_', '+/'));
}


function sso_decode_jwt(string $jwt, string $secret)
{
    $parts = explode('.', $jwt);
    if (count($parts) !== 3) {
        sso_log('info', 'JWT malformé : pas 3 parties.');
        return false;
    }

    [$header_b64, $payload_b64, $sig_b64] = $parts;

    $header = json_decode(sso_base64url_decode($header_b64), true);
    if (!is_array($header) || ($header['alg'] ?? '') !== 'HS256') {
        sso_log('info', 'JWT invalide : algorithme non supporté (' . ($header['alg'] ?? 'inconnu') . ').');
        return false;
    }

    $expected = hash_hmac('sha256', "{$header_b64}.{$payload_b64}", $secret, true);
    $provided = sso_base64url_decode($sig_b64);
    if (!hash_equals($expected, $provided)) {
        sso_log('info', 'JWT invalide : signature incorrecte (secret HMAC ne correspond pas).');
        return false;
    }

    $payload = json_decode(sso_base64url_decode($payload_b64), true);
    if (!is_array($payload)) {
        sso_log('info', 'JWT invalide : payload non décodable.');
        return false;
    }

    $now = time();
    if (isset($payload['exp']) && (int) $payload['exp'] < $now) {
        sso_log('info', 'JWT expiré (exp=' . $payload['exp'] . ', now=' . $now . ').');
        return false;
    }
    if (isset($payload['nbf']) && (int) $payload['nbf'] > $now) {
        sso_log('info', 'JWT pas encore valide (nbf=' . $payload['nbf'] . ', now=' . $now . ').');
        return false;
    }

    sso_log('debug', 'JWT valide. Payload : ' . json_encode($payload));
    return $payload;
}

/**
 * Hook init (priorité 1 = avant toute logique theme/plugin).
 *
 * Flux :
 *  1. Cookie jwt_token absent ou JWT invalide → rien.
 *  2. Utilisateur WP déjà connecté avec le bon user_login (claim "sub") → sync meta + rien d'autre.
 *  3. Utilisateur WP connecté avec un autre user_login → nettoyer la session WP.
 *  4. Chercher l'utilisateur par user_login ; le créer s'il n'existe pas.
 *  5. Ouvrir la session WordPress (set_current_user + auth_cookie).
 */
add_action('init', 'sso_jwt_intercept', 1);
function sso_jwt_intercept(): void
{
    if (is_admin() || wp_doing_cron()) {
        sso_log('debug', 'Skip : contexte admin ou cron.');
        return;
    }

    if (defined('REST_REQUEST') && REST_REQUEST) {
        sso_log('debug', 'Skip : requête REST API.');
        return;
    }

    if (!defined('SSO_JWT_SECRET') || empty(SSO_JWT_SECRET)) {
        sso_log('info', 'SSO désactivé : constante SSO_JWT_SECRET vide ou non définie.');
        return;
    }

    $jwt = $_COOKIE[SSO_JWT_COOKIE_NAME] ?? '';
    if (empty($jwt)) {
        sso_log('debug', 'Aucun cookie "' . SSO_JWT_COOKIE_NAME . '" trouvé, skip.');
        return;
    }

    sso_log('debug', 'Cookie "' . SSO_JWT_COOKIE_NAME . '" trouvé, vérification du JWT...');

    $payload = sso_decode_jwt($jwt, SSO_JWT_SECRET);
    if ($payload === false) {
        return;
    }

    $user_login    = sanitize_user($payload['sub'] ?? '', true);
    $email         = sanitize_email($payload['email'] ?? '');
    $first_name    = sanitize_text_field($payload['firstName'] ?? '');
    $last_name     = sanitize_text_field($payload['lastName'] ?? '');

    if (empty($user_login)) {
        sso_log('info', 'JWT valide mais claim "sub" (user_login) absent ou invalide.');
        return;
    }

    sso_log('debug', "Claims extraits — sub: {$user_login}, email: {$email}, firstName: {$first_name}, lastName: {$last_name}");

    // Cas 1 : déjà connecté avec le bon compte
    if (is_user_logged_in()) {
        $current = wp_get_current_user();
        if (strtolower($current->user_login) === strtolower($user_login)) {
            sso_log('debug', "Utilisateur #{$current->ID} ({$user_login}) déjà connecté, sync meta.");
            sso_sync_user_meta($current->ID, $first_name, $last_name);
            return;
        }
        // Cas 2 : un autre compte WP est connecté → nettoyer la session WP
        sso_log('info', "Conflit de session : WP connecté en tant que {$current->user_login}, JWT pour {$user_login}. Nettoyage session WP.");
        wp_clear_auth_cookie();
        wp_set_current_user(0);
    }

    $user = get_user_by('login', $user_login);
    if (!$user) {
        sso_log('info', "Aucun compte WP pour {$user_login}, création en cours...");
        $user_id = sso_create_wp_user($user_login, $email, $first_name, $last_name);
        if (!$user_id || is_wp_error($user_id)) {
            $error = is_wp_error($user_id) ? $user_id->get_error_message() : 'user_id vide';
            sso_log('info', "Échec création utilisateur {$user_login} : {$error}");
            return;
        }
        $user = get_user_by('id', $user_id);
        sso_log('info', "Compte WP créé — ID: {$user_id}, login: {$user->user_login}, email: {$email}");
    } else {
        sso_log('debug', "Compte WP existant trouvé — ID: {$user->ID}, login: {$user->user_login}");
        sso_sync_user_meta($user->ID, $first_name, $last_name);
    }

    if (!$user) {
        sso_log('info', "Impossible de récupérer l'objet WP_User après création pour {$user_login}.");
        return;
    }

    wp_set_current_user($user->ID, $user->user_login);
    wp_set_auth_cookie($user->ID, true);
    do_action('wp_login', $user->user_login, $user);

    sso_log('info', "Connexion SSO réussie — ID: {$user->ID}, login: {$user->user_login}, email: {$email}");
}

function sso_create_wp_user(string $user_login, string $email, string $first_name, string $last_name)
{
    $display_name = trim("{$first_name} {$last_name}") ?: $user_login;

    $user_id = wp_insert_user([
        'user_login'   => $user_login,
        'user_email'   => $email,
        'user_pass'    => wp_generate_password(32, true, true),
        'first_name'   => $first_name,
        'last_name'    => $last_name,
        'display_name' => $display_name,
        'role'         => SSO_JWT_DEFAULT_ROLE,
    ]);

    if (!is_wp_error($user_id)) {
        update_user_meta($user_id, '_sso_jwt_managed', true);
    }

    return $user_id;
}

function sso_sync_user_meta(int $user_id, string $first_name, string $last_name): void
{
    $user = get_userdata($user_id);
    if (!$user) {
        return;
    }

    $data         = ['ID' => $user_id];
    $needs_update = false;

    if (!empty($first_name) && $user->first_name !== $first_name) {
        $data['first_name'] = $first_name;
        $needs_update       = true;
    }
    if (!empty($last_name) && $user->last_name !== $last_name) {
        $data['last_name'] = $last_name;
        $needs_update      = true;
    }

    if ($needs_update) {
        wp_update_user($data);
    }
}


/**
 * Lors d'une déconnexion WordPress, on expire le cookie JWT sur le domaine
 * wildcard du MS pour forcer une reconnexion via le microservice SSO.
 */
add_action('wp_logout', 'sso_jwt_clear_cookie');
function sso_jwt_clear_cookie(): void
{
    setcookie(
        SSO_JWT_COOKIE_NAME,
        '',
        time() - YEAR_IN_SECONDS,
        '/',
        SSO_JWT_COOKIE_DOMAIN,
        true,   // secure (HTTPS uniquement)
        false   // httpOnly = false pour permettre au MS JS de le lire si besoin
    );

    unset($_COOKIE[SSO_JWT_COOKIE_NAME]);
}
