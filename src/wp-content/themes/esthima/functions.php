<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly
// --------------------------------------------------
// OneTrust : forcer consentement en local
// --------------------------------------------------
if (
    isset($_SERVER['HTTP_HOST']) &&
    $_SERVER['HTTP_HOST'] === 'localhost:8081'
) {
    add_action('wp_head', function () {
        ?>
        <script>
        (function () {
            // Cookie "bandeau fermé"
            document.cookie = "OptanonAlertBoxClosed=true; path=/; SameSite=Lax";

            // Cookie de consentement minimal (OneTrust)
            document.cookie = "OptanonConsent=isIABGlobal=false&datestamp=" +
                encodeURIComponent(new Date().toISOString()) +
                "&version=6.32.0&hosts=&consentId=local&interactionCount=1&landingPath=NotLandingPage; path=/; SameSite=Lax";
        })();
        </script>
        <?php
    }, 0);
}

/* BASICS */
define('API_SITE_DOMAINE', 'sc');
define('API_SITE_VERSION', '1');

//KIAMO
if (!defined('KIAMO_ENDPOINT')) define('KIAMO_ENDPOINT', sf_var('KIAMO_ENDPOINT'));
if (!defined('KIAMO_TOKEN')) define('KIAMO_TOKEN', sf_var('KIAMO_TOKEN'));
if (!defined('KIAMO_CALLBACK_QUOTE_ID')) define('KIAMO_CALLBACK_QUOTE_ID', sf_var('KIAMO_CALLBACK_QUOTE_ID'));

// add supports
add_theme_support('menus');
add_theme_support('post-thumbnails');
add_theme_support('editor-styles');
add_theme_support('responsive-embeds');
add_theme_support('custom-logo');

//add_theme_support( 'wp-block-styles' );
add_theme_support('custom-line-height');
//add_editor_style( 'style-custom.css' );


// remove some things
remove_action('wp_head', 'rsd_link'); // Removes the Really Simple Discovery link
remove_action('wp_head', 'wlwmanifest_link'); // Removes the Windows Live Writer link
remove_action('wp_head', 'wp_generator'); // Removes the WordPress version
remove_action('wp_head', 'start_post_rel_link'); // Removes the random post link
remove_action('wp_head', 'index_rel_link'); // Removes the index page link
remove_action('wp_head', 'adjacent_posts_rel_link'); // Removes the next and previous post links
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
add_filter('the_generator', '__return_empty_string'); // Removes version from rss

// remove emojis
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');


// remove scripts and styles version
function remove_scripts_styles_version($src)
{
    if (strpos($src, 'ver=' . get_bloginfo('version'))) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

add_filter('style_loader_src', 'remove_scripts_styles_version', 9999);
add_filter('script_loader_src', 'remove_scripts_styles_version', 9999);

// remove type attribute for Javascript and style
add_filter('style_loader_tag', 'codeless_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'codeless_remove_type_attr', 10, 2);
function codeless_remove_type_attr($tag, $handle)
{
    return preg_replace("/type=['\"]text\/(javascript|css)['\"]/", '', $tag);
}


// enqueue styles
function theme_enqueue_styles()
{
    wp_enqueue_style('urbanist-font', 'https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', false);
    wp_enqueue_style('style', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'));
    wp_enqueue_style('style-custom', get_stylesheet_directory_uri() . '/style-custom.css', array(), filemtime(get_template_directory() . '/style-custom.css'));
    /*landing*/
    if (is_page_template('templates/landing-1.php')) {
        wp_enqueue_style('style-landing', get_stylesheet_directory_uri() . '/style-landing.css', array(), filemtime(get_template_directory() . '/style-landing.css'));
    }
}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');


// enqueue scripts
function theme_enqueue_scripts()
{
    wp_enqueue_script('global', get_stylesheet_directory_uri() . '/js/global.js', array('jquery'), filemtime(get_template_directory() . '/js/global.js'), true);
    wp_enqueue_script('trackingDataLayer', get_stylesheet_directory_uri() . '/js/trackingDataLayer.js', array('jquery'), filemtime(get_template_directory() . '/js/trackingDataLayer.js'), true);
    wp_enqueue_script('trackingEvents', get_stylesheet_directory_uri() . '/js/trackingEvents.js', array('jquery'), filemtime(get_template_directory() . '/js/trackingEvents.js'), true);
    wp_enqueue_script('tracking', get_stylesheet_directory_uri() . '/js/tracking.js', array('jquery', 'trackingDataLayer'), filemtime(get_template_directory() . '/js/tracking.js'), true);

    $user_id = get_current_user_id();
    if ($user_id > 0) {
        $user_info = get_userdata($user_id);

        $user_data = array(
            'id' => $user_id,
            'name' => $user_info->display_name,
            'email' => $user_info->user_email,
            'email_hash' => wp_hash($user_info->user_email),
        );
    } else {
        $user_data = array();
    }

    wp_localize_script('trackingDataLayer', 'wpUserData', $user_data);
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


/*
 * Espace client (SPA Vite) de la page « Mon espace » (templates/tracking.php),
 * chargé seulement pour un utilisateur connecté. ESTHIMA_SPA_DEV choisit le
 * serveur Vite relayé par /react-dev/ (.htaccess), sinon le build publié sur
 * REACT_APP_CDN_URL, lu dans son manifeste. Le template n'affiche le point de
 * montage que si l'entrée a été enqueuée (esthima_spa_is_enqueued).
 */
function esthima_spa_enqueue(): void
{
    if (!is_page_template('templates/tracking.php') || !is_user_logged_in()) {
        return;
    }

    $GLOBALS['esthima_spa_enqueued'] = ESTHIMA_SPA_DEV ? esthima_spa_enqueue_dev() : esthima_spa_enqueue_build();
}

add_action('wp_enqueue_scripts', 'esthima_spa_enqueue');

function esthima_spa_is_enqueued(): bool
{
    return !empty($GLOBALS['esthima_spa_enqueued']);
}

// Le préambule React Refresh est importé par l'entrée elle-même.
function esthima_spa_enqueue_dev(): bool
{
    // Version null : un « ?ver= » ferait de l'entrée un second module pour Vite.
    wp_enqueue_script_module('esthima-spa-vite-client', '/react-dev/@vite/client', [], null);
    wp_enqueue_script_module('esthima-spa', '/react-dev/src/entries/wordpress.tsx', [], null);

    return true;
}

function esthima_spa_enqueue_build(): bool
{
    $assets = esthima_spa_build_assets();
    if ($assets === null) {
        return false;
    }

    foreach ($assets['css'] as $index => $url) {
        wp_enqueue_style('esthima-spa-' . $index, $url, [], null);
    }
    wp_enqueue_script_module('esthima-spa', $assets['module'], [], null);

    return true;
}

/*
 * URLs de l'entrée « wordpress » du build et des CSS de l'entrée et de ses
 * imports, gardées une minute. Si le manifeste est absent ou incohérent, le
 * dernier manifeste valide sert ; sans lui, null.
 */
function esthima_spa_build_assets(): ?array
{
    $cached = get_transient('esthima_spa_assets');
    if (is_array($cached)) {
        return $cached;
    }

    $assets = esthima_spa_assets_from_cdn();
    if ($assets !== null) {
        update_option('esthima_spa_assets_last', $assets, false);
    } else {
        $assets = get_option('esthima_spa_assets_last') ?: null;
    }
    if ($assets !== null) {
        set_transient('esthima_spa_assets', $assets, MINUTE_IN_SECONDS);
    }

    return $assets;
}

function esthima_spa_assets_from_cdn(): ?array
{
    if (REACT_APP_CDN_URL === '') {
        error_log('[esthima-spa] REACT_APP_CDN_URL est vide : aucun build à charger.');
        return null;
    }

    $base         = trailingslashit(REACT_APP_CDN_URL);
    $manifest_url = $base . 'manifest.json';
    $response     = wp_remote_get($manifest_url, ['timeout' => 2]);
    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
        error_log("[esthima-spa] Manifeste indisponible : $manifest_url");
        return null;
    }

    $manifest  = json_decode(wp_remote_retrieve_body($response), true);
    $entry_key = is_array($manifest) ? esthima_spa_wordpress_entry_key($manifest) : null;
    $css_files = $entry_key !== null ? esthima_spa_css_files($manifest, $entry_key) : null;
    if ($css_files === null) {
        error_log("[esthima-spa] Manifeste sans entrée « wordpress » cohérente : $manifest_url");
        return null;
    }

    return [
        'module' => $base . $manifest[$entry_key]['file'],
        'css'    => array_map(fn(string $file): string => $base . $file, $css_files),
    ];
}

// Seule l'entrée nommée « wordpress » est résolue, jamais l'entrée standalone.
function esthima_spa_wordpress_entry_key(array $manifest): ?string
{
    $keys = array_keys(array_filter(
        $manifest,
        fn($chunk): bool => is_array($chunk) && ($chunk['isEntry'] ?? false) === true && ($chunk['name'] ?? null) === 'wordpress'
    ));
    if (count($keys) !== 1 || !esthima_spa_is_asset_path($manifest[$keys[0]]['file'] ?? null, 'js')) {
        return null;
    }

    return $keys[0];
}

// CSS des imports statiques puis du chunk, dans l'ordre du build Vite ; null si incohérent.
function esthima_spa_css_files(array $manifest, string $key, array &$visited = []): ?array
{
    if (isset($visited[$key])) {
        return [];
    }
    $visited[$key] = true;
    $chunk = $manifest[$key] ?? null;
    if (!is_array($chunk)) {
        return null;
    }

    $files = [];
    foreach ((array) ($chunk['imports'] ?? []) as $import) {
        $imported = is_string($import) ? esthima_spa_css_files($manifest, $import, $visited) : null;
        if ($imported === null) {
            return null;
        }
        $files = array_merge($files, $imported);
    }
    foreach ((array) ($chunk['css'] ?? []) as $file) {
        if (!esthima_spa_is_asset_path($file, 'css')) {
            return null;
        }
        $files[] = $file;
    }

    return $files;
}

function esthima_spa_is_asset_path($path, string $extension): bool
{
    return is_string($path) && preg_match('#^assets/[\w.-]+\.' . $extension . '$#', $path) === 1;
}


function enqueue_contact_tracking_script() {
    // Vérifier si on est sur la page contact
    if (is_page('contact') || is_page_template('page-contact.php')) {
        wp_enqueue_script(
            'contact-tracking',
            get_template_directory_uri() . '/src/js/contact-tracking.js',
            array(),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_contact_tracking_script');


/* CONSTANTES */
require get_template_directory() . '/inc/map_url.php';

/* PLUGINS CUSTOM FUNCTIONS */
require get_template_directory() . '/inc/plugins_functions.php';

/* CLASS */

/* ADMIN */
require get_template_directory() . '/inc/admin.php';

/* ELEMENTOR */
require get_template_directory() . '/inc/elementor.php';

/* SHORTCODES */
require get_template_directory() . '/inc/shortcodes.php';

/* THEME FUNCTIONS */
require get_template_directory() . '/inc/theme_functions.php';

/* WIDGET INCLUDE PARTIAL */
require get_template_directory() . '/inc/widget_include_partial.php';

/* SERVICE */
require get_template_directory() . '/inc/kiamo.php';

require get_template_directory() . '/services/service-petsconfigurator.php';

// Remove trailing slash from pagination links
add_filter('paginate_links', 'untrailingslashit');
add_filter('get_pagenum_link', 'untrailingslashit');

/**
 * Redirection automatique vers la page d'ID 833 si un produit est introuvable (404).
 */
function redirect_missing_product_to_specific_page()
{
    if (is_404()) {
        global $wp;

        // Construit l'URL actuelle
        $current_url = home_url($wp->request);

        // Vérifie si l'URL correspond à un produit WooCommerce (slug par défaut : "product")
        // Ajustez '/product/' si vous avez un slug personnalisé (ex: '/boutique/').
        if (strpos($current_url, '/produit/') !== false) {
            // Redirection vers la page dont l'ID est 833
            wp_redirect(get_permalink(833));
            exit;
        }
    }
}

add_action('template_redirect', 'redirect_missing_product_to_specific_page');

/**
 * Supprime le forfait de livraison si aucun livre est dans le panier.
 */
add_filter('woocommerce_package_rates', function ($rates, $package) {
    $has_book = false;

    $book_shipping_class = 'livre';

    foreach ($package['contents'] as $item) {
        $product = $item['data'];
        if ($product->get_shipping_class() === $book_shipping_class) {
            $has_book = true;
            break;
        }
    }

    if (!$has_book) {
        foreach ($rates as $rate_id => $rate) {
            if (strpos($rate_id, 'flat_rate') !== false) {
                unset($rates[$rate_id]);
            }
        }
    }

    return $rates;
}, 10, 2);


// Helper pour prendre les variables d'environnement Salesforce (prod/recette)
function sf_var($key_base): bool|array|string
{
    $env = getenv('ENV') ?: 'prod';
    $key = strtoupper("{$key_base}_" . $env);
    $value = getenv($key);
    if ($value === false) {
        // fallback sur la prod, au cas où
        $value = getenv(strtoupper("{$key_base}_prod"));
    }
    return $value;
}

add_filter('wpseo_canonical', function ($canonical) {
    if (is_paged()) {
        global $wp;
        return home_url(add_query_arg([], $wp->request));
    }

    return $canonical;
});

// Authentification avec Salesforce
add_filter('init', function () {
    $username = 'esthima.website';
    $password = 'qB1TxD1xXdTS271e';

    $jwt_token = $_COOKIE['token'] ?? '';
    if ($jwt_token !== '') {
        return;
    }

    // Appel à ton API externe avec les identifiants
    $response = wp_remote_post(API_URL . '/login', [
        'body' => json_encode([
            'username' => $username,
            'password' => $password
        ]),

        'headers' => [
            'Content-Type' => 'application/json'
        ]
    ]);

    if (is_wp_error($response)) {
        return;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!empty($data['token'])) {
        // On stocke le token en cookie
        setcookie('token', $data['token'], time() + 3600, '/');
    }

}, 30, 3);
