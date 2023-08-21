<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// Move Yoast Panel to bottom of the admin page
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');


// Metabox Styling
function metabox_styling() {
	?>
	<style type="text/css">
        #editor .postbox {
			margin-bottom: 20px !important;
		}
		#editor .postbox > .postbox-header {
			border-top: 2px solid #72aee6 !important;
    		background: #f8f8f8;
		}
		#editor .postbox > .postbox-header .hndle {
			padding-left: 30px;
		}
		#editor .postbox > .postbox-header .hndle::before {
			content: "";
			position: absolute;
			display: block;
			width: 10px;
			height: 10px;
			background: #72aee6;
			left: 10px;
		}

		#editor .postbox.acf-postbox > .postbox-header {
			border-top: 2px solid #00dab4 !important;
		}
		#editor .postbox.acf-postbox > .postbox-header .hndle::before {
			background: #00dab4;
		}
		acf-postbox
    </style>
	<?php
}
add_action('admin_enqueue_scripts', 'metabox_styling');


// Admin menu Styling
function admin_menu_styling() {
	?>
	<style type="text/css">
		/* CPT PUBLICS */
        #adminmenu li.menu-icon-realisation,
		#adminmenu li.menu-icon-document,
		#adminmenu li.menu-icon-produit,
		#adminmenu li.menu-icon-recompense {
			background-color: #4d5065;
		}

		/* CPT PRIVES */
		#adminmenu li.menu-icon-fiche-technique,
		#adminmenu li.menu-icon-dessin-technique,
		#adminmenu li.menu-icon-dessin-realisation,
		#adminmenu li.menu-icon-documentation,
		#adminmenu li.menu-icon-reference {
			background-color: #593055;
		}

		/* ELEMENTOR */
		#adminmenu li[id*="elementor"]{
			background-color: #494e48;
		}
    </style>
	<?php
}
add_action('admin_enqueue_scripts', 'admin_menu_styling');


/* Add item to admin top bar */
function k_add_toolbar_items($admin_bar){
	/* Show current page used template file */
	if ( !is_admin() && is_super_admin() ) {
		global $template;
		$admin_bar->add_menu( array(
	    	'id'    => 'current-template',
	        'title' => "<div style='background:green; padding: 0 20px;margin-left: -10px;'>".basename($template)."</div>",
	        'meta'  => array(
	            'title' => __('Current Template'),            
	        ),
	    ));
	}
}
add_action('admin_bar_menu', 'k_add_toolbar_items', 1);


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

/* Woocommerce - admin product list - add product type column */
function action_manage_product_posts_custom_column( $column, $postid ) {        
    if ( $column == 'name' ) {
        // Get product
        $product = wc_get_product( $postid );
        // Get type
        $product_type = $product->get_type();
        // Output
        echo '&nbsp;<span>&ndash; ' .  ucfirst( $product_type ) . '</span>';
    }
}
add_action( 'manage_product_posts_custom_column', 'action_manage_product_posts_custom_column', 20, 2 );
