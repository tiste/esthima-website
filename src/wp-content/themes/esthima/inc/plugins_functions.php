<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly

/* ACF - ADD OPTION PAGE */
if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Options',
        'menu_title'    => 'Options',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
    
    acf_add_options_sub_page(array(
        'page_title'    => 'Options Header',
        'menu_title'    => 'Header',
        'parent_slug'   => 'theme-general-settings',
    ));
    
    acf_add_options_sub_page(array(
        'page_title'    => 'Options Footer',
        'menu_title'    => 'Footer',
        'parent_slug'   => 'theme-general-settings',
    ));
	
}

//add desc loop products
add_action( 'woocommerce_shop_loop_item_title', 'add_desc_loop', 10 );
if ( ! function_exists( 'add_desc_loop' ) ) {
	function add_desc_loop() {
		echo '<div class="woocommerce-loop-product__desc">' . get_the_excerpt() . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo do_shortcode('[yith_compare_button]');
        echo do_shortcode('[yith_wcwl_add_to_wishlist]');
	}
}