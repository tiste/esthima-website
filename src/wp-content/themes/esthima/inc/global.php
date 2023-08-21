<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/* add supports */
add_theme_support( 'menus' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'editor-styles' );
add_theme_support( 'responsive-embeds' );
add_theme_support( 'custom-logo' );

//add_theme_support( 'wp-block-styles' );

/**
 * Add HTML5 theme support.
 */
function goodact_search_support_html5() {
	add_theme_support( 'html5', array( 'search-form' ) );
}
add_action( 'after_setup_theme', 'goodact_search_support_html5' );


/* remove some things */
remove_action( 'wp_head', 'rsd_link' ); // Removes the Really Simple Discovery link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Removes the Windows Live Writer link
remove_action( 'wp_head', 'wp_generator' ); // Removes the WordPress version
remove_action( 'wp_head', 'start_post_rel_link' ); // Removes the random post link
remove_action( 'wp_head', 'index_rel_link' ); // Removes the index page link
remove_action( 'wp_head', 'adjacent_posts_rel_link' ); // Removes the next and previous post links
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
add_filter( 'the_generator', '__return_empty_string' ); // Removes version from rss

/* remove emojis */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );


/* remove scripts and styles version */
function remove_scripts_styles_version( $src ) {
	if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'remove_scripts_styles_version', 9999 );
add_filter( 'script_loader_src', 'remove_scripts_styles_version', 9999 );

/* remove type attribute for Javascript and style */
add_filter('style_loader_tag', 'codeless_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'codeless_remove_type_attr', 10, 2);
function codeless_remove_type_attr($tag, $handle) {
	return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}


/* enqueue styles */
function theme_enqueue_styles() {
	//wp_enqueue_style( 'montserrat-font', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;900&display=swap', false );
	//wp_enqueue_style( 'offcanvas-nav', get_stylesheet_directory_uri() . '/hc-offcanvas-nav.css', array(), filemtime(  get_template_directory() . '/hc-offcanvas-nav.css' ) );
	wp_enqueue_style( 'style', get_stylesheet_uri(), array(), filemtime(  get_template_directory() . '/style.css' ) );
	wp_enqueue_style( 'style-custom', get_stylesheet_directory_uri() . '/style-custom.css', array(), filemtime(  get_template_directory() . '/style-custom.css' ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 9999 ); //9999 to load after all plugins CSS


/* enqueue scripts */
function theme_enqueue_scripts() {
	wp_enqueue_script( 'global', get_stylesheet_directory_uri() . '/js/global.js', array('jquery', 'offcanvas'), filemtime(  get_template_directory() . '/js/global.js' ), true );
	//wp_enqueue_script( 'offcanvas', get_stylesheet_directory_uri() . '/js/hc-offcanvas-nav.js', array('jquery'), filemtime(  get_template_directory() . '/js/hc-offcanvas-nav.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
