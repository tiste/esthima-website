<?php

namespace GtmEcommerceWooPro\Lib\Util;

use GtmEcommerceWoo\Lib\GaEcommerceEntity\Event;
use GtmEcommerceWoo\Lib\GaEcommerceEntity\Item;
use GtmEcommerceWoo\Lib\Util\WcTransformerUtil as FreeWcTransformerUtil;
use GtmEcommerceWooPro\Lib\Type\EventType;
use WC_Order;
use WC_Product_Variation;

/**
 * Logic to handle embedding Gtm Snippet
 */
class WcTransformerUtil extends FreeWcTransformerUtil {

	public function getRefundFromOrderId( $orderId, array $refunds ) {
		$order = wc_get_order( $orderId );

		return $this->getRefundFromOrder($order, $refunds);
	}

	public function getRefundFromOrder( WC_Order $order, array $refunds) {
		$event = new Event( EventType::REFUND );
		$event->setTransactionId( $order->get_order_number() );

		foreach ( $refunds as $refund ) {
			foreach ( $refund->get_items() as $key => $orderItem ) {
				$item           = $this->getItemFromOrderItem( $orderItem );
				$item->quantity = -$item->quantity;
				$event->addItem( $item );
			}
		}

		return $event;
	}

	public function getItemFromCartItem( $cartItem ) {
		$product = wc_get_product( $cartItem['data']->get_id() );
		// Review possible usage of getItemFromOrderItem
		$item = $this->getItemFromProduct( $product );
		$item->setQuantity( $cartItem['quantity'] );
		return $item;
	}

	/**
	 * Url: https://woocommerce.github.io/code-reference/classes/WC-Product-Variation.html
	 */
	public function getItemFromProductVariation( WC_Product_Variation $product ) {
		$parentProduct = wc_get_product($product->get_parent_id());

		$regularPrice = wc_get_price_including_tax($product, ['price' => $product->get_regular_price(null)]);
		$salePrice = wc_get_price_including_tax($product);
		$discount = $regularPrice - $salePrice;

		$item = new Item( $parentProduct->get_name() );
		$item->setItemId( $product->get_id() );
		$item->setPrice( $salePrice );
		$item->setItemVariant($product->get_name());

		if (0 < $discount) {
			$item->setDiscount($discount);
		}

		$productCats = get_the_terms( $product->get_id(), 'product_cat' );
		if ( is_array( $productCats ) ) {
			$categories = array_map(
				static function( $category ) {
					return $category->name; },
				$productCats
			);
			$item->setItemCategories( $categories );
		}
		/**
		 * Filter allowing to manipulate the event item objects
		 *
		 * @since 1.6.0
		 */
		return apply_filters('gtm_ecommerce_woo_item', $item, $product);
	}
}
