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
        //echo do_shortcode('[yith_compare_button]');
        echo do_shortcode('[yith_wcwl_add_to_wishlist]');
	}
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 1 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


/* page contact - envoie à l'action demandée */
// 'https://webto.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8'
// 'https://test.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8'
add_action( 'gform_after_submission_2', 'post_to_third_party', 10, 2 );
function post_to_third_party( $entry, $form ) {
 
    $endpoint_url = 'https://test.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8';
    $body = array(
        'debug' => '0',
        'oid' => '00D24000000jNFO',
        'retURL' => 'https://devis.esthima.fr/#/',
        'debugEmail' => 'francois-xavier.desmidt@cie-veterinaires.fr',
        'lead_source' => 'Web_funeral', 
        'salutation' => rgar( $entry, '1' ),
        'last_name' => rgar( $entry, '2' ),
        'email' => rgar( $entry, '4' ),
    );
    GFCommon::log_debug( 'gform_after_submission: body => ' . print_r( $body, true ) );
 
    $response = wp_remote_post( $endpoint_url, array( 'body' => $body ) );
    GFCommon::log_debug( 'gform_after_submission: response => ' . print_r( $response, true ) );
}


//produit variable : "dès X€"
add_filter( 'woocommerce_variable_sale_price_html', 'lw_variable_product_price', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'lw_variable_product_price', 10, 2 );

function lw_variable_product_price( $v_price, $v_product ) {
    if(is_product()){
        // Product Price
        $prod_prices = array(
            $v_product->get_variation_price( 'min', true ), 
            $v_product->get_variation_price( 'max', true )
        );
        $prod_price = $prod_prices[0]!==$prod_prices[1] ? sprintf(__('<span style="font-size:0.4em;">Dès</span> %1$s', 'woocommerce'), wc_price( $prod_prices[0] ) ) : wc_price( $prod_prices[0] );
    
        // Regular Price
        $regular_prices = array(
            $v_product->get_variation_regular_price( 'min', true ), 
            $v_product->get_variation_regular_price( 'max', true )
        );
        sort( $regular_prices );
        $regular_price = $regular_prices[0]!==$regular_prices[1] ? sprintf(__('<span style="font-size:0.4em;">Dès</span> %1$s','woocommerce'), wc_price( $regular_prices[0] ) ) : wc_price( $regular_prices[0] );
    
        if ( $prod_price !== $regular_price ) {
            $prod_price = '<del>'.$regular_price.$v_product->get_price_suffix() . '</del> <ins>' . 
            $prod_price . $v_product->get_price_suffix() . '</ins>';
        }
        return $prod_price;
    }else{
        return $v_price;
    }
}

// ajout validation tel francais
// add_filter( 'gform_phone_formats', 'fr_phone_format' );
function fr_phone_format( $phone_formats ) {
    $phone_formats['fr'] = array(
        'label'       => 'France',
        'mask'        => '9 99 99 99 99',
        'regex'       => '/^[1|2|3|4|5|6|7|8|9][0-9]{8}$/',
        'instruction' => false,
    );
    $phone_formats['fr2'] = array(
        'label'       => 'France avec 0',
        'mask'        => '99 99 99 99 99',
        'regex'       => '/^[0][1|2|3|4|5|6|7|8|9][0-9]{8}$/',
        'instruction' => false,
    );
    $phone_formats['cp'] = array(
        'label'       => 'Code postal',
        'mask'        => '99999',
        'regex'       => '/^[0-9]{5}$/',
        'instruction' => false,
    );
 
    return $phone_formats;
}

add_filter('wc_add_to_cart_message', 'handler_function_name', 10, 2);
function handler_function_name($message, $product_id) {
    // return "Thank you for adding product" . $product_id;
    $patate = strip_tags( get_the_title( $product_id ));
    return "L'article \"" . $patate . "\" a été ajouté au panier.";
}