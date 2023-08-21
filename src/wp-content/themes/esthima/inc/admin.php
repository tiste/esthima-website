<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


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


/* ADMIN : LIST PAGE : add custom post states */
function custom_post_states($states) {
    global $post;
    // if( ('templates/liste-reseaux.php'==get_page_template_slug($post->ID)) )
    //     $states[] = __('<span style="border:2px solid #F27063;color: #F27063;font-size: 11px;padding: 2px 10px;border-radius:50px;">SC - Liste réseaux</span>');
    // if( ('templates/liste-structures.php'==get_page_template_slug($post->ID)) )
    //     $states[] = __('<span style="border:2px solid #F27063;color: #F27063;font-size: 11px;padding: 2px 10px;border-radius:50px;">SC - Liste structures</span>');
	// if( ('templates/liste-compagnies.php'==get_page_template_slug($post->ID)) )
    //     $states[] = __('<span style="border:2px solid #F27063;color: #F27063;font-size: 11px;padding: 2px 10px;border-radius:50px;">SC - Liste compagnies</span>');
	// if( ('templates/liste-projets.php'==get_page_template_slug($post->ID)) )
    //     $states[] = __('<span style="border:2px solid #F27063;color: #F27063;font-size: 11px;padding: 2px 10px;border-radius:50px;">SC - Liste projets</span>');

    return $states;
}
add_filter('display_post_states', 'custom_post_states');
