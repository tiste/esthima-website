<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

/* enqueue JS specific to page */
add_filter( 'template_include', function($template){

	// if( basename( $template ) == 'mon-compte.php' ) {
	// 	wp_enqueue_script( 'ihc-print-this', IHC_URL . 'assets/js/printThis.js', ['jquery'], 10.2 );
	// }

	// if ( strpos( $_SERVER[ 'REQUEST_URI' ], MAP_URLS['REGISTER'] ) !== false) {
	// 	wp_enqueue_script( 'formPayment', get_stylesheet_directory_uri() . '/js/formPayment.js', array(), filemtime(  get_template_directory() . '/js/formPayment.js' ), true );
	// }
	
	return $template;
}, 99 );



/* add the 'Lost Password" link to the login form */
add_action( 'login_form_middle', 'add_lost_password_link' );
function add_lost_password_link() {
	return '<a class="s-login-form__reset-password" href="/wp-login.php?action=lostpassword">J\'ai oublié mon mot de passe</a>';
}



/* Fix Select2 issues with WordPress Admin Bar */
add_action( 'wp_head', 'smyles_output_select2_admin_bar_fix' );
function smyles_output_select2_admin_bar_fix() {
	$type_attr = current_theme_supports( 'html5', 'style' ) ? '' : ' type = "text/css"';
	
	/**
	 * We use ~ here instead of + for any situations where something else ends up attaching to body as well
	 */
	?>
	<style<?php echo $type_attr; ?> media="screen">
		div#wpadminbar ~ span.select2-container, body.admin-bar > span.select2-container {
			padding-top: 32px !important;
		}

		@media screen and ( max-width: 782px ) {
			div#wpadminbar ~ span.select2-container, body.admin-bar > span.select2-container {
				padding-top: 46px !important;
			}
		}
	</style>
	<?php
}



/* Change the Width of the Gutenberg Editor */
/* https://www.megademic.com/how-to-change-the-width-of-the-gutenberg-editor/ */

// Gutenberg Editor Styles
function megademic_gutenberg_editor_styles() {
    echo '
        <style>
            /* Main column width */
            .wp-block { max-width: 1100px; }
 
            /* Width of "wide" blocks */
            .wp-block[data-align="wide"] { max-width: 1280px; }
 
            /* Width of "full-width" blocks */
            .wp-block[data-align="full"] { max-width: none; }    
        </style>
    ';
}
add_action( 'admin_head', 'megademic_gutenberg_editor_styles' );

/* wpsl - markers custom */
define( 'WPSL_MARKER_URI', dirname( get_bloginfo( 'stylesheet_url') ) . '/wpsl-markers/' );
add_filter( 'wpsl_admin_marker_dir', 'custom_admin_marker_dir' );
function custom_admin_marker_dir() {
    $admin_marker_dir = get_stylesheet_directory() . '/wpsl-markers/';
    return $admin_marker_dir;
}

/* wpsl - taille picto liste */
add_filter( 'wpsl_thumb_size', 'custom_thumb_size' );
function custom_thumb_size() {
    $size = array( 230, 260 );   
    return $size;
}


/* wpsl - recup category */
add_filter( 'wpsl_store_meta', 'custom_store_meta', 10, 2 );
function custom_store_meta( $store_meta, $store_id ) {
	$terms = get_the_terms( $store_id, 'wpsl_store_category' );
	$store_meta['terms'] = '';
	if ( $terms ) {
		if ( ! is_wp_error( $terms ) ) {
			if ( count( $terms ) > 1 ) {
				$location_terms = array();
				foreach ( $terms as $term ) {
					$location_terms[] = $term->name;
				}
				$store_meta['terms'] = implode( ', ', $location_terms );
			} else {
				$store_meta['terms'] = $terms[0]->name;
			}
		}
	}
	return $store_meta;
}

/* wpsl - custom fields */
// add_filter( 'wpsl_meta_box_fields', 'custom_meta_box_fields' );
// function custom_meta_box_fields( $meta_fields ) {
//     $meta_fields[__( 'Additional Information', 'wpsl' )] = array(
//         'phone' => array(
//             'label' => __( 'Tel', 'wpsl' )
//         ),
//         'phone2' => array(
//             'label' => __( 'Tel 2', 'wpsl' )
//         ),
//         'fax' => array(
//             'label' => __( 'Fax', 'wpsl' )
//         ),
//         'email' => array(
//             'label' => __( 'Email', 'wpsl' )
//         ),
//         'url' => array(
//             'label' => __( 'Url', 'wpsl' )
//         ),
//         'agenceboutique' => array(
//             'label' => __( 'Agence / Boutique', 'wpsl' )
//         ),
//         'horairessimples' => array(
//             'label' => __( 'Horaires simplifiés', 'wpsl' )
//         ),
//         'storetitle' => array(
//             'label' => __( "Nom de l'agence", 'wpsl' )
//         )
//     );
//     return $meta_fields;
// }

/* wpsl - custom template list */
add_filter( 'wpsl_listing_template', 'custom_listing_template' );
function custom_listing_template() {

    global $wpsl, $wpsl_settings;
    
    $listing_template = '<li data-store-id="<%= id %>" class="storeloc__map__store">' . "\r\n";

	$listing_template .= "\t\t" . '<a href="<%= permalink %>"  class="storeloc__map__store__img">' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<%= thumb %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<img src="'.get_template_directory_uri().'/images/default-store.jpg">' . "\r\n";
	$listing_template .= "\t\t" . "</a>" . "\r\n";

	$listing_template .= "\t\t" . '<div class="storeloc__map__store__infos">' . "\r\n";
	// $listing_template .= "\t\t\t\t" . '<% if ( terms ) { %>' . "\r\n";
	// $listing_template .= "\t\t\t\t" . '<div class="storeloc__map__store__infos__surtitle"><%= terms %> de</div>' . "\r\n";
	// $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
	$listing_template .= "\t\t\t\t" . '<a href="<%= permalink %>" class="storeloc__map__store__infos__title"><h3>' . "\r\n";
	$listing_template .= "\t\t\t\t\t\t" . '<% if ( terms ) { %>' . "\r\n";
	$listing_template .= "\t\t\t\t\t\t" . '<span><%= terms %> de</span>' . "\r\n";
	$listing_template .= "\t\t\t\t\t\t" . '<% } %>' . "\r\n";
	$listing_template .= "\t\t\t\t\t\t" . '<%= store %>' . "\r\n";
	$listing_template .= "\t\t\t\t" . '</h3></a>' . "\r\n";
	$listing_template .= "\t\t\t\t" . '<div class="storeloc__map__store__infos__adresse"><%= address %></div>' . "\r\n";
	$listing_template .= "\t\t\t\t" . '<div class="storeloc__map__store__infos__adresse"><%= address2 %></div>' . "\r\n";
	$listing_template .= "\t\t\t\t" . '<div class="storeloc__map__store__infos__adresse">'.wpsl_address_format_placeholders().'</div>' . "\r\n";
	$listing_template .= "\t\t\t\t" . '<div class="storeloc__map__store__infos__btns">' . "\r\n";
	$listing_template .= "\t\t\t\t\t\t" . '<a href="'.home_url('/').'prendre-rdv/" class="storeloc__map__store__infos__btns__rdv">Prendre rendez-vous</a>' . "\r\n";
	$listing_template .= "\t\t\t\t\t\t" . '<% if ( phone ) { %>' . "\r\n";
	$listing_template .= "\t\t\t\t\t\t" . '<a href="tel:<%= phone %>" class="storeloc__map__store__infos__btns__call">Nous appeler</a>' . "\r\n";
	$listing_template .= "\t\t\t\t\t\t" . '<% } %>' . "\r\n";
	$listing_template .= "\t\t\t\t" . '</div>' . "\r\n";
	$listing_template .= "\t\t\t\t" . '<a href="<%= permalink %>" class="storeloc__map__store__infos__link">Voir la fiche</a>' . "\r\n";
	$listing_template .= "\t\t" . "</div>" . "\r\n";
    
    $listing_template .= '</li>';

    return $listing_template;
}



add_filter( 'woocommerce_account_menu_items', 'modifyMenuAccount' );

function modifyMenuAccount( $menu_links ){
	return array(
		//'dashboard' => __( 'Dashboard', 'esthima' ),
        'edit-account' => __( 'Mon profil', 'esthima' ), //native WC endpoint "Modifier le compte"
		'mes-devis' => __( 'Mes devis', 'esthima' ), //custom mon compte child page "Mes devis"
        'orders' => __( 'Mes commandes', 'esthima' ), //native WC endpoint "Commandes"
        'mes-favoris' => __( 'Mes favoris', 'esthima' ), //custom mon compte child page "Mes favoris"
		'customer-logout' => __( 'Me déconnecter', 'esthima' ) //native WC endpoint "Déconnexion"
	);
}

add_action( 'init', 'esthima_add_endpoints' );
function esthima_add_endpoints() {
	add_rewrite_endpoint( 'mes-devis', EP_PAGES );
	add_rewrite_endpoint( 'mes-favoris', EP_PAGES );
}

add_action( 'woocommerce_account_mes-devis_endpoint', 'esthima_my_account_endpoint_mes_devis_content' );
function esthima_my_account_endpoint_mes_devis_content() {
	echo 'test';
}
add_action( 'woocommerce_account_mes-favoris_endpoint', 'esthima_my_account_endpoint_mes_favoris_content' );
function esthima_my_account_endpoint_mes_favoris_content() {
	//echo 'test2';
	echo '<div class="account-wishlist">' . do_shortcode('[yith_wcwl_wishlist pagination="no"]') . '</div>';
}
