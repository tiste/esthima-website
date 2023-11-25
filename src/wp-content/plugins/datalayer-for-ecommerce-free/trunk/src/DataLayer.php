<?php
/**
 * DataLayer Init
 *
 * @version 1.0.1
 * @package 'datalayer'
 */

namespace DatalayerForWoocommerceFree;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'DataLayer' ) ) :
	/**
	 * Class DataLayer
	 */
	class DataLayer {

		/**
		 * Push to DataLayer
		 *
		 * @param array $data_layer     Receive values and encoded.
		 * @name 'push_to_data_layer'
		 */
		public static function push_to_data_layer( $data_layer ) {
			$encoded_data_layer = wp_json_encode( $data_layer );
			wc_enqueue_js(
				'
        if(typeof dataLayer == "undefined"){
            dataLayer = [];
        }
        dataLayer.push(' . $encoded_data_layer . ');
        '
			);
		}

		/**
		 * Push to DataLayer with TimeOut
		 *
		 * @param array $data_layer     Receive values and encoded.
		 * @name 'push_to_data_layer'
		 */
		public static function push_to_data_layer_sleep( $data_layer ) {
			$encoded_data_layer = wp_json_encode( $data_layer );
			wc_enqueue_js(
				'
        setTimeout( function() {
        if(typeof dataLayer == "undefined"){
            dataLayer = [];
        }
            dataLayer.push(' . $encoded_data_layer . ')
        }, 5000);
        '
			);
		}

		/**
		 * Verify if DataLayer is UA option
		 *
		 * @name 'is_data_layer_ua'
		 */
		public static function is_data_layer_ua() {
			$options = get_option( 'options_tracking_option_free' );
			if ( isset( $options['data_layer_google_tag_manager_enhanced_ecommerce'] ) ) {
				if ( $options['data_layer_google_tag_manager_enhanced_ecommerce'] ) {
					return true;
				}
			}
			return false;
		}

		/**
		 * Verify if DataLayer is GA4 option
		 *
		 * @name 'is_data_layer_ga4'
		 */
		public static function is_data_layer_ga4() {
			$options = get_option( 'options_tracking_option_free' );
			if ( isset( $options['data_layer_google_tag_manager_ecommerce_ga4'] ) ) {
				if ( $options['data_layer_google_tag_manager_ecommerce_ga4'] ) {
					return true;
				}
			}
			return false;
		}

		/**
		 * Generate_event_id_datalayer
		 *
		 * @name 'generate_event_id_datalayer'
		 * @return string
		 */
		public static function generate_event_id_datalayer() {
			$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

			return substr( str_shuffle( str_repeat( $pool, 10 ) ), 0, 10 );
		}

	}
endif;
