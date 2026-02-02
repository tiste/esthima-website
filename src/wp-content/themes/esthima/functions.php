<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly

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
     wp_enqueue_script( 'animal-tracking', get_stylesheet_directory_uri() . '/src/js/animal-tracking.js', array('jquery', 'trackingDataLayer'), filemtime(  get_template_directory() . '/src/js/animal-tracking.js' ), true );

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

    $jwt_token = $_COOKIE['token'];
    if ($jwt_token) {
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
