<?php

namespace GtmEcommerceWooPro\Lib\EventStrategy\Browser\Purchase;

use GtmEcommerceWoo\Lib\GaEcommerceEntity\Event;
use GtmEcommerceWooPro\Lib\Type\EventType;
use WC_Order;
use GtmEcommerceWoo\Lib\EventStrategy\PurchaseStrategy as FreePurchaseStrategy;

class BeforePaymentRedirectStrategy extends FreePurchaseStrategy {
	use PurchaseStrategyTrait;

	public function initialize() {
		parent::initialize();

		add_action(
			'rest_api_init',
			function () {
				register_rest_route(
					'gtm-ecommerce-woo/v1',
					'/track-order/(?P<order_id>\d+)',
					[
						'methods'             => 'POST',
						'callback'            => [ $this, 'endpointTrackOrder' ],
						'permission_callback' => '__return_true',
					]
				);
			}
		);
	}

	public function defineActions() {
		return [
			'woocommerce_before_checkout_form' => [$this, 'checkoutForm'],
			'woocommerce_checkout_order_processed' => [[$this, 'ajaxCheckout'], 10, 3],
		];
	}

	public function ajaxCheckout( $orderId, $postedData, WC_Order $order) {
		if (false === $this->shouldTrack($order)) {
			return;
		}

		$purchaseEvent = $this->wcTransformer->getPurchaseFromOrder($order);
		$userDataEvent = ( new Event(EventType::USER_DATA) )
			->setExtraProperty('email', $order->get_billing_email())
			->setExtraProperty('phone_number', $order->get_billing_phone())
		;

		$serializedPurchaseEvent = base64_encode(json_encode($purchaseEvent));
		$serializedUserDataEvent = base64_encode(json_encode($userDataEvent));

		add_filter(
			'woocommerce_payment_successful_result',
			static function( $result ) use ( $serializedPurchaseEvent, $serializedUserDataEvent ) {
				$result['gtm_ecommerce_woo_purchase_event'] = $serializedPurchaseEvent;
				$result['gtm_ecommerce_woo_user_data_event'] = $serializedUserDataEvent;

				return $result;
			}
		);
	}

	public function checkoutForm() {
		$trackOrderEndpointUrlPattern = sprintf('%s%s%s', get_rest_url(), 'gtm-ecommerce-woo/v1', '/track-order/%d');
		$this->wcOutput->script(
			<<<EOD
(function($, dataLayer){
	const checkoutForm = $('form.checkout');

	if (0 === checkoutForm.length) {
		return;
	}

	checkoutForm.on('checkout_place_order_success', function(event, result) {
		try {
			const responseObject = {
				result: null,
				gtm_ecommerce_woo_purchase_event: null,
				gtm_ecommerce_woo_user_data_event: null,
				...result
			};

			if ('success' !== responseObject.result || null === responseObject.gtm_ecommerce_woo_purchase_event) {
				return true;
			}

			if (null !== responseObject.gtm_ecommerce_woo_user_data_event) {
				const userDataEvent = JSON.parse(atob(responseObject.gtm_ecommerce_woo_user_data_event));
				dataLayer.push(userDataEvent);
			}

			const purchaseEvent = JSON.parse(atob(responseObject.gtm_ecommerce_woo_purchase_event));
			dataLayer.push(purchaseEvent);

			const orderId = purchaseEvent.ecommerce.transaction_id;

			$.ajax({
				type: 'POST',
				async: false,
				url: '{$trackOrderEndpointUrlPattern}'.replace('%d', orderId),
			});
		} catch (e) {}

		return true;
	});
})(jQuery, dataLayer);
EOD
		);
	}

	public function endpointTrackOrder( $data) {
		if (false === isset($data['order_id'])) {
			return;
		}

		$order = wc_get_order( (int) $data['order_id'] );

		if (false === $order instanceof WC_Order) {
			return;
		}

		$order->update_meta_data(self::ORDER_META_KEY_PURCHASE_EVENT_TRACKED, '1');
		$order->save();

		sleep(1);
	}
}
