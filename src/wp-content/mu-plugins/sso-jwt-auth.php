<?php
/**
 * Plugin Name: SSO JWT Auth
 * Description: Intercepte le cookie JWT posé par le microservice SSO sur *.esthima.fr
 *              et connecte/crée automatiquement l'utilisateur WordPress correspondant.
 * Version:     1.0.0
 */

if (!defined('ABSPATH')) exit;

if (!defined('SSO_JWT_COOKIE_NAME'))   define('SSO_JWT_COOKIE_NAME',   'jwt_token');
if (!defined('SSO_JWT_COOKIE_DOMAIN')) define('SSO_JWT_COOKIE_DOMAIN', '.esthima.fr');
if (!defined('SSO_JWT_DEFAULT_ROLE'))  define('SSO_JWT_DEFAULT_ROLE',  'customer');
if (!defined('SSO_JWT_DEBUG'))         define('SSO_JWT_DEBUG',         false);
if (!defined('SSO_JWT_PUBLIC_KEY'))    define('SSO_JWT_PUBLIC_KEY',    '');
if (!defined('SSO_JWT_ISSUER'))        define('SSO_JWT_ISSUER',        '');
if (!defined('SSO_JWT_AUDIENCE'))      define('SSO_JWT_AUDIENCE',      '');
if (!defined('SSO_LOGOUT_URL'))        define('SSO_LOGOUT_URL',        '');

// Les comptes SSO ont leur email synchronisé automatiquement depuis le JWT à
// chaque login ; on désactive la notification native WP "Your Email Address
// was changed" pour ne pas spammer les utilisateurs lors de ces synchros.
add_filter('send_email_change_email', '__return_false');


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


/**
 * Clé publique RS256 du SSO. Dans .env, la clé PEM tient sur une ligne : ses
 * retours à la ligne y sont écrits "\n" et sont rétablis ici.
 *
 * @return OpenSSLAsymmetricKey|false
 */
function sso_jwt_public_key()
{
    return openssl_pkey_get_public(str_replace('\n', "\n", SSO_JWT_PUBLIC_KEY));
}

/**
 * Retourne le payload d'un JWT RS256 signé par le SSO et destiné à ce site,
 * ou false. Seul OpenSSL vérifie la signature : ce code ne fait que découper le
 * jeton et contrôler les claims.
 *
 * @param OpenSSLAsymmetricKey $public_key
 * @return array|false
 */
function sso_decode_jwt(string $jwt, $public_key)
{
    $parts = explode('.', $jwt);
    if (count($parts) !== 3) {
        sso_log('info', 'JWT malformé : pas 3 parties.');
        return false;
    }

    [$header_b64, $payload_b64, $sig_b64] = $parts;

    // L'algorithme est imposé : un jeton "none" ou HS256 n'est jamais accepté.
    $header = json_decode(sso_base64url_decode($header_b64), true);
    if (!is_array($header) || ($header['alg'] ?? '') !== 'RS256') {
        sso_log('info', 'JWT invalide : algorithme non supporté.');
        return false;
    }

    $signature = sso_base64url_decode($sig_b64);
    if (openssl_verify("{$header_b64}.{$payload_b64}", $signature, $public_key, OPENSSL_ALGO_SHA256) !== 1) {
        sso_log('info', 'JWT invalide : signature incorrecte.');
        return false;
    }

    $payload = json_decode(sso_base64url_decode($payload_b64), true);
    if (!is_array($payload)) {
        sso_log('info', 'JWT invalide : payload non décodable.');
        return false;
    }

    $rejection = sso_jwt_claims_rejection($payload, time());
    if ($rejection !== null) {
        sso_log('info', "JWT rejeté : {$rejection}.");
        return false;
    }

    return $payload;
}

/**
 * Raison du refus des claims, ou null s'ils sont acceptés.
 */
function sso_jwt_claims_rejection(array $payload, int $now): ?string
{
    if (($payload['iss'] ?? null) !== SSO_JWT_ISSUER) {
        return 'claim "iss" inattendu';
    }

    // "aud" peut être une chaîne ou un tableau d'audiences.
    $audiences = (array) ($payload['aud'] ?? []);
    if (!in_array(SSO_JWT_AUDIENCE, $audiences, true)) {
        return 'claim "aud" inattendu';
    }

    if (!is_string($payload['sub'] ?? null) || $payload['sub'] === '') {
        return 'claim "sub" absent';
    }

    // "exp" est obligatoire : sans lui, un token volé resterait valable indéfiniment.
    if (!is_numeric($payload['exp'] ?? null) || (int) $payload['exp'] <= $now) {
        return 'claim "exp" absent ou passé';
    }

    if (isset($payload['nbf']) && (!is_numeric($payload['nbf']) || (int) $payload['nbf'] > $now)) {
        return 'claim "nbf" pas encore atteint';
    }

    return null;
}

/**
 * Hook init (priorité 1 = avant toute logique theme/plugin).
 *
 * Flux :
 *  1. Cookie jwt_token absent ou JWT invalide → fermeture de la session WP issue du SSO.
 *  2. Utilisateur WP déjà connecté avec le bon user_login (claim "sub") → sync meta + rien d'autre.
 *  3. Utilisateur WP connecté avec un autre user_login → nettoyer la session WP.
 *  4. Chercher l'utilisateur par user_login ; le créer s'il n'existe pas.
 *  5. Ouvrir la session WordPress (set_current_user + auth_cookie borné sur l'exp du JWT).
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

    if (SSO_JWT_PUBLIC_KEY === '' || SSO_JWT_ISSUER === '' || SSO_JWT_AUDIENCE === '') {
        sso_log('debug', 'SSO désactivé : SSO_JWT_PUBLIC_KEY, SSO_JWT_ISSUER ou SSO_JWT_AUDIENCE vide.');
        return;
    }

    $public_key = sso_jwt_public_key();
    if ($public_key === false) {
        sso_log('debug', 'SSO désactivé : SSO_JWT_PUBLIC_KEY n\'est pas une clé publique PEM lisible.');
        return;
    }

    $jwt = $_COOKIE[SSO_JWT_COOKIE_NAME] ?? '';

    // Le JWT est la seule source de vérité de la session : s'il est absent ou
    // invalide (expiré, signature KO...), toute session WP issue du SSO doit
    // être fermée. Sans ça, le cookie WP survivrait au token.
    $payload = $jwt !== '' ? sso_decode_jwt($jwt, $public_key) : false;

    if ($payload === false) {
        if ($jwt === '') {
            sso_log('debug', 'Aucun cookie "' . SSO_JWT_COOKIE_NAME . '" trouvé.');
        }
        sso_jwt_logout_if_sso_session();
        return;
    }

    sso_log('debug', 'Cookie "' . SSO_JWT_COOKIE_NAME . '" trouvé, JWT valide.');

    $user_login    = sanitize_user($payload['sub'] ?? '', true);
    $email         = sanitize_email($payload['email'] ?? '');
    $first_name    = sanitize_text_field($payload['firstName'] ?? '');
    $last_name     = sanitize_text_field($payload['lastName'] ?? '');

    if (empty($user_login)) {
        sso_log('info', 'JWT valide mais claim "sub" (user_login) absent ou invalide.');
        sso_jwt_logout_if_sso_session();
        return;
    }

    // Cas 1 : déjà connecté avec le bon compte
    if (is_user_logged_in()) {
        $current = wp_get_current_user();
        if (strtolower($current->user_login) === strtolower($user_login)) {
            sso_log('debug', "Utilisateur #{$current->ID} déjà connecté, sync meta.");
            sso_sync_user_meta($current->ID, $email, $first_name, $last_name);

            // wp_update_user() a déjà mis à jour la base, mais l'objet WP_User courant (chargé en mémoire dès l'appel
            // is_user_logged_in() plus haut) garde en cache les anciennes valeurs des colonnes natives de wp_users
            // (dont user_email) pour le reste de la requête. wp_set_current_user() ne suffit pas ici : WordPress
            // court-circuite le rechargement si l'ID demandé est déjà celui du current_user. On force donc
            // explicitement la reconstruction de l'objet global pour que le reste du rendu de la page
            // (ex. tracking.php) voie les données fraîches dès ce même chargement de page.
            global $current_user;
            $current_user = new WP_User($current->ID);
            return;
        }
        // Cas 2 : un autre compte WP est connecté → nettoyer la session WP
        sso_log('info', "Conflit de session : WP connecté en tant que #{$current->ID}, JWT pour un autre compte. Nettoyage session WP.");
        wp_clear_auth_cookie();
        wp_set_current_user(0);
    }

    $user = get_user_by('login', $user_login);
    if (!$user) {
        sso_log('info', "Aucun compte WP pour ce sub, création en cours...");
        $user_id = sso_create_wp_user($user_login, $email, $first_name, $last_name);
        if (!$user_id || is_wp_error($user_id)) {
            $error = is_wp_error($user_id) ? $user_id->get_error_message() : 'user_id vide';
            sso_log('info', "Échec création utilisateur : {$error}");
            return;
        }
        $user = get_user_by('id', $user_id);
        sso_log('info', "Compte WP créé — ID: {$user_id}");
    } else {
        sso_log('debug', "Compte WP existant trouvé — ID: {$user->ID}");
        sso_sync_user_meta($user->ID, $email, $first_name, $last_name);
    }

    if (!$user) {
        sso_log('info', "Impossible de récupérer l'objet WP_User après création.");
        return;
    }

    wp_set_current_user($user->ID, $user->user_login);
    sso_jwt_set_auth_cookie($user->ID, (int) $payload['exp']);
    do_action('wp_login', $user->user_login, $user);

    sso_log('info', "Connexion SSO réussie — ID: {$user->ID}");
}

/**
 * Ferme la session WordPress si (et seulement si) elle a été ouverte par le SSO.
 *
 * On se base sur la SESSION et non sur l'utilisateur : un même compte peut très
 * bien avoir une session SSO (à fermer quand le JWT tombe) et une session native
 * ouverte via wp-login.php (à conserver, elle ne dépend pas du JWT). Se baser sur
 * une meta utilisateur déconnecterait à tort les connexions natives, et ne
 * couvrirait pas les comptes préexistants rattachés après coup au SSO.
 */
function sso_jwt_logout_if_sso_session(): void
{
    if (!is_user_logged_in()) {
        return;
    }

    $current = wp_get_current_user();

    if (!sso_jwt_is_sso_session($current->ID)) {
        sso_log('debug', "Pas de JWT valide, mais session non-SSO pour #{$current->ID} : session WP conservée.");
        return;
    }

    sso_log('info', "JWT absent/invalide → déconnexion WP de la session SSO #{$current->ID}.");

    // wp_logout() (et non wp_clear_auth_cookie) : détruit aussi le session token
    // en base et déclenche l'action wp_logout (session WooCommerce, etc.).
    wp_logout();
}

/**
 * La session WordPress courante a-t-elle été ouverte par le SSO ?
 *
 * Le marqueur est posé dans les métadonnées de session (voir
 * sso_jwt_set_auth_cookie). Le repli sur "_sso_jwt_managed" ne sert qu'aux
 * sessions ouvertes avant l'introduction de ce marqueur : il est volontairement
 * restreint aux comptes sans capacité d'administration, pour ne jamais
 * verrouiller un administrateur connecté via wp-login.php.
 */
function sso_jwt_is_sso_session(int $user_id): bool
{
    $token = wp_get_session_token();

    if ($token !== '') {
        $session = WP_Session_Tokens::get_instance($user_id)->get($token);
        if (is_array($session) && array_key_exists('sso', $session)) {
            return (bool) $session['sso'];
        }
    }

    // Repli transitoire (sessions antérieures au marqueur).
    return (bool) get_user_meta($user_id, '_sso_jwt_managed', true)
        && !user_can($user_id, 'manage_options');
}

/**
 * Ouvre la session WordPress en bornant la durée du cookie sur l'expiration du JWT.
 *
 * Le cookie WP reste nécessaire : les appels admin-ajax.php (panier WooCommerce)
 * et l'API REST ne passent pas par cet intercepteur et n'ont donc que lui pour
 * identifier l'utilisateur. En revanche il ne doit jamais survivre au JWT, sinon
 * un utilisateur resterait connecté après expiration du token.
 *
 * La session est marquée "sso" pour pouvoir la fermer quand le JWT n'est plus
 * valide, sans toucher aux éventuelles sessions natives du même compte.
 */
function sso_jwt_set_auth_cookie(int $user_id, int $jwt_exp): void
{
    $ttl = $jwt_exp - time();
    if ($ttl < 1) {
        return;
    }

    $limit_expiration = static function () use ($ttl) {
        return $ttl;
    };
    $mark_sso_session = static function (array $info) {
        $info['sso'] = true;
        return $info;
    };
    // Les nonces de la page en cours, dont celui de l'URL de déconnexion, dépendent
    // du jeton de session lu dans le cookie de la requête : sans cela, la première
    // page après la connexion SSO porterait un nonce de déconnexion refusé.
    $expose_cookie_to_request = static function (string $logged_in_cookie) {
        $_COOKIE[LOGGED_IN_COOKIE] = $logged_in_cookie;
    };

    add_filter('auth_cookie_expiration', $limit_expiration, PHP_INT_MAX);
    add_filter('attach_session_information', $mark_sso_session, PHP_INT_MAX);
    add_action('set_logged_in_cookie', $expose_cookie_to_request);

    wp_set_auth_cookie($user_id, true);

    remove_action('set_logged_in_cookie', $expose_cookie_to_request);
    remove_filter('attach_session_information', $mark_sso_session, PHP_INT_MAX);
    remove_filter('auth_cookie_expiration', $limit_expiration, PHP_INT_MAX);

    sso_log('debug', "Cookie WP posé pour user #{$user_id}, durée alignée sur le JWT ({$ttl}s).");
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

function sso_sync_user_meta(int $user_id, string $email, string $first_name, string $last_name): void
{
    $user = get_userdata($user_id);
    if (!$user) {
        return;
    }

    $data         = ['ID' => $user_id];
    $needs_update = false;

    if (!empty($email) && strtolower($user->user_email) !== strtolower($email)) {
        $existing = email_exists($email);
        if ($existing && (int) $existing !== $user_id) {
            sso_log('info', "Conflit email : déjà utilisé par le compte #{$existing}, synchro email ignorée pour user #{$user_id}.");
        } else {
            $data['user_email'] = $email;
            $needs_update       = true;
        }
    }

    if (!empty($first_name) && $user->first_name !== $first_name) {
        $data['first_name'] = $first_name;
        $needs_update       = true;
    }
    if (!empty($last_name) && $user->last_name !== $last_name) {
        $data['last_name'] = $last_name;
        $needs_update      = true;
    }

    if ($needs_update) {
        $result = wp_update_user($data);
        if (is_wp_error($result)) {
            sso_log('info', "Échec synchro user #{$user_id} : " . $result->get_error_message());
        }
    }
}


/**
 * Lors d'une déconnexion WordPress, on expire le cookie JWT avec les mêmes
 * Domain et Path que le SSO pour forcer une reconnexion via le microservice.
 * Vider $_COOKIE ne suffit pas : seul un Set-Cookie expiré atteint le navigateur.
 */
add_action('wp_logout', 'sso_jwt_clear_cookie');
function sso_jwt_clear_cookie(): void
{
    if (!isset($_COOKIE[SSO_JWT_COOKIE_NAME])) {
        return;
    }
    unset($_COOKIE[SSO_JWT_COOKIE_NAME]);
    setcookie(SSO_JWT_COOKIE_NAME, '', [
        'expires'  => 1,
        'path'     => '/',
        'domain'   => SSO_JWT_COOKIE_DOMAIN,
        'secure'   => true,
        'httponly' => true,
    ]);

    // Seule une déconnexion de session SSO est redirigée ; les autres gardent la leur.
    add_filter('logout_redirect', 'sso_jwt_logout_redirect');
}

/**
 * Après la déconnexion WordPress, la navigation continue vers la déconnexion
 * du SSO si elle est configurée, sinon vers l'accueil.
 */
function sso_jwt_logout_redirect(): string
{
    return SSO_LOGOUT_URL !== '' ? SSO_LOGOUT_URL : home_url();
}

// wp-login.php redirige avec wp_safe_redirect, qui refuse un hôte externe non autorisé.
add_filter('allowed_redirect_hosts', 'sso_jwt_allow_logout_host');
function sso_jwt_allow_logout_host(array $hosts): array
{
    $logout_host = wp_parse_url(SSO_LOGOUT_URL, PHP_URL_HOST);
    if (is_string($logout_host)) {
        $hosts[] = $logout_host;
    }
    return $hosts;
}
