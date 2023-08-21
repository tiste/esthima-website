<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/* Disable WordPress Admin Bar for all users */
//add_filter( 'show_admin_bar', '__return_false' );


/* category_has_parent (is subcategory) */
function category_has_parent($cat_id){
    $category = get_category($cat_id);
    if ($category->category_parent > 0){
        return true;
    }
    return false;
}


/* term_has_parent (is subterm) */
function term_has_parent($term_id){
    $term = get_term($term_id);
    if ($term->parent > 0){
        return true;
    }
    return false;
}

/**
 * @snippet       Add "Subcategory" Class to HTML Body
 * @how-to          Get CustomizeWoo.com FREE
 * @author          Rodolfo Melogli
 * @compatible    WooCommerce 5
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

add_filter( 'body_class', 'goodact_wc_product_cats_css_body_class' );

function goodact_wc_product_cats_css_body_class( $classes ){
   if ( is_tax( 'product_cat' ) ) {
      $cat = get_queried_object();
      if ( $cat->parent > 0  ) $classes[] = 'subcategory';
   }
   return $classes;
}


/*  yith filters to archive product page - hook before shop loop */
function goodact_woocommerce_before_shop_loop(){
	if ( !is_shop() ) {
		echo do_shortcode('[yith_wcan_filters slug="draft-preset"]');
	}
}
add_action( 'woocommerce_before_shop_loop', 'goodact_woocommerce_before_shop_loop', 5 );


/* insert ad card to archive product page - hook before shop loop items */
function goodact_insert_ad() {

	if ( is_archive() ) {
		global $wp_query;

		if( $wp_query->current_post === 7 ) : ?>
			<a href="<?php echo home_url(); ?>/generateur-didees-cadeaux" class="inspi-card">
				<div class="inspi-card__close adcardClose">&times;</div>
			</a>
		<?php endif;
	}
}
// add_action( 'woocommerce_before_shop_loop_item', 'goodact_insert_ad', 5 );

//add_action( 'woocommerce_shop_loop', 'amc_add_content_after_4_product_for_once' );
function amc_add_content_after_4_product_for_once() {
    if ( is_archive() ) {
		global $wp_query;

		if( $wp_query->current_post === 7 ) : ?>
            <li class="product card-panne-inspi">
                <a href="<?php echo home_url(); ?>/generateur-didees-cadeaux" class="inspi-card"></a>
            </li>
		<?php endif;
	}
}

add_filter( 'loop_shop_per_page', 'lw_loop_shop_per_page', 30 );
function lw_loop_shop_per_page( $products ) {
 $products = 47;
 return $products;
}

add_filter( 'woocommerce_account_menu_items', 'modifyMenuAccount' );

function modifyMenuAccount( $menu_links ){
	return array(
		//'dashboard' => __( 'Dashboard', 'goodact' ),
        'modifier-le-compte' => __( 'Mon profil', 'goodact' ), //native WC endpoint "Modifier le compte"
        'orders' => __( 'Mes commandes', 'goodact' ), //native WC endpoint "Commandes"
        'consulter-mes-bat' => __( 'Consulter mes BAT', 'goodact' ), //Attach me plugin WC endpoint "Téléchargements"
        'mes-points-fidelite' => __( 'Mes points fidélité', 'goodact' ), //custom mon compte child page "Mes points fidélité"
        'soutenir-une-cause' => __( 'Soutenir une cause', 'goodact' ), //404 : currently no endpoint and no child page
        'adresse' => __( 'Mes adresses', 'goodact' ), //native WC endpoint "Adresses"
		'deconnexion' => __( 'Me déconnecter', 'goodact' ) //native WC endpoint "Déconnexion"
	);
}


/**
 *  if product single from request a quote => class to make specific styles
 */
function goodact_request_quote_body_classes( $classes ) {
    if($_GET['requestquote']==1){
      $classes[] = 'requestquote';
    }      
    return $classes;
}
add_filter( 'body_class', 'goodact_request_quote_body_classes' );




/**
 *  Account children pages functions
 */

/* savoir si on est sur une page enfant de la page mon compte */
function goodact_is_account_children_page(){
    if (wp_get_post_parent_id()==get_option( 'woocommerce_myaccount_page_id' )) {
        return true;
    }
    else {
        return false;
    }
}


/**
 *  goodact_account_children_page : si on est sur une page enfant de la page compte, alors on indique que c'est une page du compte. Cela ajoute les classes utile sur le <body> (hook WC : woocommerce_is_account_page)
 */

 add_filter( 'woocommerce_is_account_page', 'goodact_account_children_page' );
 function goodact_account_children_page( $false ) {
     if (goodact_is_account_children_page()) {
         return true;
     } 
 }
