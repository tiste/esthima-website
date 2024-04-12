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

	global $wpsl, $wpsl_settings, $wpsl_admin;
	
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
	$listing_template .= "\t\t\t\t" . '<div class="storeloc__map__store__infos__opening" ></div>' . "\r\n";
	$listing_template .= "\t\t\t" . '<p style="display:none"><%= hours %></p>' . "\r\n"; 
	$listing_template .= "\t\t\t\t" . '<div class="storeloc__map__store__infos__adresse"><%= address %></div>' . "\r\n";
	$listing_template .= "\t\t\t\t" . '<div class="storeloc__map__store__infos__adresse"><%= address2 %></div>' . "\r\n";
	$listing_template .= "\t\t\t\t" . '<div class="storeloc__map__store__infos__adresse">'.wpsl_address_format_placeholders().'</div>' . "\r\n";
	$listing_template .= "\t\t\t\t" . '<div class="storeloc__map__store__infos__btns">' . "\r\n";
	$listing_template .= "\t\t\t\t\t\t" . '<a href="'.home_url('/').'prendre-rdv" class="storeloc__map__store__infos__btns__rdv">Prendre rendez-vous</a>' . "\r\n";
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
	echo 'Aucun devis';
}
add_action( 'woocommerce_account_mes-favoris_endpoint', 'esthima_my_account_endpoint_mes_favoris_content' );
function esthima_my_account_endpoint_mes_favoris_content() {
	//echo 'test2';
	echo '<div class="account-wishlist">' . do_shortcode('[yith_wcwl_wishlist pagination="no"]') . '</div>';
}

add_filter('wpseo_breadcrumb_links', function($links) {
	
	if(is_singular('guide')) {
		$linkTmp = [];
		$linkTmp[0] = $links[0];
		$linkTmp[1] = [
			'url' => home_url('conseils-actualites'),
			'text' => "Nos guides & nos conseils"
		];
		$linkTmp[2] = $links[1];
		$linkTmp[3] = $links[2];
		$links = $linkTmp;
    }

	if(is_singular('product')) {
		$linkTmp = [];
		$linkTmp[0] = $links[0];
		$linkTmp[1] = [
			'url' => home_url('boutique'),
			'text' => "Boutique"
		];
		$linkTmp[2] = $links[1];
		$linkTmp[3] = $links[2];
		$links = $linkTmp;
    }

	if(is_archive() && basename($template)=='guides-conseils.php') {

		$taxonomy = get_queried_object()->taxonomy;

		if ($taxonomy == "guide_cat") {

			$linkTmp = [];
			$linkTmp[0] = $links[0];
			$linkTmp[1] = [
				'url' => home_url('conseils-actualites'),
				'text' => "Nos guides & nos conseils"
			];

			foreach ($links as $l) {
				$linkTmp[] = $l;
			}

			$links = $linkTmp;
		}
	}
	return $links;
});

// add_action('wp_head', function($output = ''){
// 	global $template;
// 	if( is_home() ){
// 		global $page_id;
// 		$output = home_url( '/actualites' );
// 		$paged = get_query_var('paged');
// 		if ($paged) {
// 			$output .= "/page/" . $paged;
// 		}
// 	}
// 	if( is_category() ){ global $cat; $output = get_category_link($cat); }
// 	if( is_tag() ){ global $tag_id; $output = get_tag_link($tag_id); }
// 	if( is_page() ){
// 		global $page_id;
// 		$output = get_page_link($page_id);
// 		$paged = get_query_var('paged');
// 		if ($paged) {
// 			$output .= "/page/" . $paged;
// 		}
// 	}
// 	if( is_single() ){ $output = get_permalink(); }
// 	if(basename($template)=='archive-product.php'){
// 		$output = home_url( '/produits' );
// 		$paged = get_query_var('paged');
// 		if ($paged) {
// 			$output .= "/page/" . $paged;
// 		}
// 	}
// 	if(is_tax()){
// 		$output = get_term_link(get_queried_object());
// 		$paged = get_query_var('paged');
// 		if ($paged) {
// 			$output .= "/page/" . $paged;
// 		}
// 	}
// 	if( $output != '' ){ echo '<link rel="canonical" href="'.$output.'">'; }
// });

add_filter('wp_title', function($title) {
	if( is_page() ){
		$paged = get_query_var('paged');
		if ($paged) {
			$title .= " Page " . $paged . " | Esthima";
		}
	} else if (is_archive()) {
		// $paged = get_query_var('paged');
		// if ($paged) {
		// 	$title .= " Page " . $paged . " | Esthima";
		// }
	}
	return $title;
});

add_filter( 'wpseo_schema_graph', function($data, $context) {
	global $post;

	if (is_singular('guide')){

		$schema_data = [
			"@context" => "https://schema.org",
			"@type" => "Article",
			"headline" => get_the_title(),
			"image" => [
				get_the_post_thumbnail_url('1x1'),
				get_the_post_thumbnail_url('4x3'),
				get_the_post_thumbnail_url('16x9')
			],
			"datePublished" => get_the_date('c'),
			"dateModified" => get_the_modified_date('c'),
			"author" => [],
		];
	
		$author_id = get_post_field( 'post_author', $post->ID );
		$author_name = get_the_author_meta( 'display_name', $author_id );


		$schema_data['author'][] = [
			"@type" => "Person",
			"name" => $author_name,
			"url" => get_author_posts_url($author_id),
		];

		$data[] = $schema_data;
	
	}

	if (is_page('crematoriums')) {
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// die;
	}

	return $data;
}, 10, 2 );

// add_filter( 'paginate_links', function($link){

// 	if (is_paged()) {
// 		$link = str_replace('/page/1', '', $link);
// 	}
//     return $link;
// });

add_action('woocommerce_get_breadcrumb', function($crumbs, $that){
	$crumbsTmp = [];
	$crumbsTmp[0] = $crumbs[0];
	$crumbsTmp[1][0] = "Boutique";
	$crumbsTmp[1][1] = home_url('boutique');

	foreach ($crumbs as $ckey => $cvalue) {
		if ($ckey > 0) {
			$crumbsTmp[] = $cvalue;
		}
	}

	$crumbs = $crumbsTmp;

	return $crumbs;
}, 10, 2);



add_action('woocommerce_before_shop_loop_item', function(){
	global $product;
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->id ), 'single-post-thumbnail' );

	echo '<div itemscope itemtype="http://schema.org/Product">
	<link itemprop="url" href="' . get_the_permalink($product->id) . '" />
	<meta itemprop="name" content="' . $product->get_name() . '" />
	<link itemprop="image" href="' . $image[0] . '" />
	<meta itemprop="brand" content="Esthima" />
	<meta itemprop="sku" content="' . $product->get_sku() . '" />
	<meta itemprop="description" content="' . htmlspecialchars($product->get_description()) . '" />';

	echo '<div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
	<link itemprop="availability" href="https://schema.org/InStock" />
	<meta itemprop="url" content="' . get_the_permalink($product->id) . '" />
	<meta itemprop="priceCurrency" content="EUR" />
	<meta itemprop="price" content="' . $product->get_price() . '" />
	</div></div>';
});


add_filter( 'wpseo_schema_graph_pieces', 'remove_breadcrumbs_from_schema', 11, 2 );
function remove_breadcrumbs_from_schema( $pieces, $context ) {
	if(isset($context->indexable->object_sub_type)){
		if($context->indexable->object_sub_type=='product' || $context->indexable->object_sub_type=='product_cat' || $context->indexable->object_sub_type=='wpsl_stores'){
			return \array_filter( $pieces, function( $piece ) {
				return ! $piece instanceof \Yoast\WP\SEO\Generators\Schema\Breadcrumb;
			} );
		}else{
			return $pieces;
		}
	}else{
		return $pieces;
	}
}

add_action( 'template_redirect', 'removePageNumber' );
function removePageNumber() {
    if ( is_home() && wp_count_posts('post')<10 ){
		add_filter( 'wpseo_next_rel_link', '__return_false' );
		add_filter( 'wpseo_prev_rel_link', '__return_false' );
	}
	return false;
}

//Disable the new user notification sent to the site admin
function smartwp_disable_new_user_notifications() {
	//Remove original use created emails
	remove_action( 'register_new_user', 'wp_send_new_user_notifications' );
	remove_action( 'edit_user_created_user', 'wp_send_new_user_notifications', 10, 2 );
	
	//Add new function to take over email creation
	add_action( 'register_new_user', 'smartwp_send_new_user_notifications' );
	add_action( 'edit_user_created_user', 'smartwp_send_new_user_notifications', 10, 2 );
   }
   function smartwp_send_new_user_notifications( $user_id, $notify = 'user' ) {
	if ( empty($notify) || $notify == 'admin' ) {
	return;
	}elseif( $notify == 'both' ){
	//Only send the new user their email, not the admin
	$notify = 'user';
	}
	wp_send_new_user_notifications( $user_id, $notify );
   }
   add_action( 'init', 'smartwp_disable_new_user_notifications' );