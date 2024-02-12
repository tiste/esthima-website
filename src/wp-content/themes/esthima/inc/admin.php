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


// Add the custom columns to the devis post type:
add_filter( 'manage_devis_posts_columns', 'set_custom_edit_devis_columns' );
function set_custom_edit_devis_columns($columns) {
    unset( $columns['telechargement'] );
    $columns['devis_telechargement'] = __( 'Téléchargement des devis', 'esthima' ); 

    return $columns;
}

// Add the data to the custom columns for the devis post type:
add_action( 'manage_devis_posts_custom_column' , 'custom_devis_column', 10, 2 );
function custom_devis_column( $column, $post_id ) {
    switch ( $column ) {

        case 'devis_telechargement' :
            $terms = get_the_term_list( $post_id , 'devis_telechargement' , '' , ',' , '' );
            if (   $post_id  )
                echo '<a href="/wp-json/esthima/v1/generate-pdf/?id=' . $post_id .'" target="_blank"> Télécharger le devis  </a>';
            else
                _e( "Il n'y a pas de devis à telecharger", 'esthima' );
            break; 

    }
}