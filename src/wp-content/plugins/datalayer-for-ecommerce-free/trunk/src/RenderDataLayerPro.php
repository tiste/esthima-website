<?php
/**
 * RenderDataLayerPro Init
 *
 * @version 1.0.2
 * @package 'datalayer'
 */

namespace DatalayerForWoocommerceFree;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'RenderDataLayerPro' ) ) :
	/**
	 * Class RenderDataLayerPro
	 */
	class RenderDataLayerPro {

		/**
		 * Instance
		 *
		 * @var null $instance Instance.
		 */
		protected static $instance = null;

		/**
		 * Holds the values to be used in the fields callbacks
		 *
		 * @var $options Options Page.
		 */
		private $options;

		/**
		 * Start up
		 */
		private function __construct() {
			$this->options = get_option( 'options_tracking_option_free' );
			$checked_ua    = 0;
			if ( isset( $this->options['data_layer_google_tag_manager_enhanced_ecommerce'] ) ) {
				if ( $this->options['data_layer_google_tag_manager_enhanced_ecommerce'] ) {
					$checked_ua = 1;
				}
			}
			$checked_ga4 = 0;
			if ( isset( $this->options['data_layer_google_tag_manager_ecommerce_ga4'] ) ) {
				if ( $this->options['data_layer_google_tag_manager_ecommerce_ga4'] ) {
					$checked_ga4 = 1;
				}
			}
			if ( $checked_ua || $checked_ga4 ) :
				if ( ! $this->has_valid_requirements() ) {
					add_action( 'admin_notices', array( Notices::class, 'add_notice_requires_woocommerce_activated' ) );
					return;
				}

				if ( $checked_ua ) :
					add_action('admin_init', array( Notices::class, 'add_notice_datalayer_ua_deprecated' ) );
				endif;

				add_action( 'wp_head', array( $this, 'search_page_trigger' ), 30 );
				add_action( 'woocommerce_thankyou', array( $this, 'purchase_trigger' ), 40 );
			endif;
		}

		/**
		 * Remove to Cart Ajax Trigger
		 *
		 * @name 'has_valid_requirements'
		 * @return bool
		 */
		private function has_valid_requirements() {

			$plugin_path = trailingslashit( WP_PLUGIN_DIR ) . 'woocommerce/woocommerce.php';
			if ( in_array( $plugin_path, wp_get_active_and_valid_plugins(), true ) ) {
				return true;
			}

			$network_active_plugins = get_site_option('active_sitewide_plugins');
			if ( ( ! empty($network_active_plugins) && array_key_exists('woocommerce/woocommerce.php', $network_active_plugins) ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Return an instance of this class.
		 *
		 * @return object A single instance of this class.
		 */
		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Search Page Trigger
		 *
		 * @name 'search_page_trigger'
		 */
		public function search_page_trigger() {
			/** VIEW PRODUCT DETAILS */
			if ( is_product() ) {
				$product = wc_get_product( get_the_ID() );
				if ( is_object( $product ) ) {
					$products_related = array();
				}
				$product_related_products = wc_get_related_products( get_the_ID(), 3 );
				if ( is_array( $product_related_products ) && ! empty( $product_related_products ) ) :
					foreach ( $product_related_products as $key => $post ) :
						$products_related[] = wc_get_product( $post );
					endforeach;
				endif;
				RenderProduct::mount_measuring_views_of_product_details_data_layer( $product, $products_related );
			}
		}

		/**
		 * Purchase_trigger
		 *
		 * @param int $order_id       Order ID.
		 */
		public function purchase_trigger( $order_id ) {
			/** PURCHASE */
			RenderCheckout::measuring_checkout_purchase_data_layer( $order_id );
		}

	}

endif;
