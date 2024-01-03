<?php

namespace GtmEcommerceWooPro\Lib\EventStrategy\Browser;

use GtmEcommerceWoo\Lib\EventStrategy\AbstractEventStrategy;
use GtmEcommerceWoo\Lib\GaEcommerceEntity\Event;
use GtmEcommerceWooPro\Lib\Service\GtmSnippetService;
use GtmEcommerceWooPro\Lib\Type\EventType;
use WC_Order;

class UserDataStrategy extends AbstractEventStrategy {

	protected $eventName = EventType::USER_DATA;

	public function defineActions() {
		return [
			'wp_head' => [[$this, 'wpHead'], GtmSnippetService::PRIORITY_BEFORE_GTM ],
		];
	}

	public function wpHead() {
		if (false === is_wc_endpoint_url('order-received')) {
			return;
		}

		if (false === isset($_GET['key'])) {
			return;
		}

		$orderKey = sanitize_text_field($_GET['key']);
		$orderId = wc_get_order_id_by_order_key($orderKey);

		if (null === $orderId) {
			return;
		}

		/** WC_Order @var WC_Order|false $order*/
		$order = wc_get_order($orderId);

		if (false === $order) {
			return;
		}


		$event = ( new Event(EventType::USER_DATA) )
			->setExtraProperty('email', $order->get_billing_email())
			->setExtraProperty('phone_number', $order->get_billing_phone())
		;

		$serializedEvent = json_encode($event);

		echo sprintf(
			"<script>var dataLayer = dataLayer || [];dataLayer.push(%s);</script>\n",
			filter_var($serializedEvent, FILTER_FLAG_STRIP_BACKTICK)
		);
	}

}
