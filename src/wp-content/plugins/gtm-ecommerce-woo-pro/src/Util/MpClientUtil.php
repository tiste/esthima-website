<?php

namespace GtmEcommerceWooPro\Lib\Util;

use GtmEcommerceWoo\Lib\Util\WpSettingsUtil;

/**
 * MeasurementProtocol Utility
 */
class MpClientUtil extends WpSettingsUtil {
	public function getClientId() {
		if (isset($_COOKIE['_ga'])) {
			return str_replace('GA1.2.', '', filter_var($_COOKIE['_ga']));
		}

		if (isset(WC()->session) && WC()->session->get_session_cookie()) {
			return implode('.', WC()->session->get_session_cookie());
		}

		return vsprintf( '%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4) );
	}

	public function sendEvents( $events, $clientId = null ) {
		if (null === $clientId) {
			$clientId = $this->getClientId();
		}

		$serverEvents = array_map(function( $event) {
			$rawEvent = $event->jsonSerialize();
			$serverEvent = [
				'name' => $event->name,
				'params' => $rawEvent['ecommerce']
			];

			unset($serverEvent['params']['purchase']);

			// workaround to flatten extra params with ecommerce
			foreach ($event->extraProps as $propName => $propValue) {
				$serverEvent['params'][$propName] = $propValue;
			}
			return $serverEvent;
		}, $events);

		$url = rtrim($this->getOption('gtm_server_container_url'), '/');
		$path = ltrim($this->getOption('gtm_server_ga4_client_activation_path'), '/');
		$args = [
			'body' => json_encode([
				'client_id' => $clientId,
				'v' => 2,
				'events' => $serverEvents,
			]),
			'headers' => [
				'content-type' => 'application/json',
				'x-gtm-server-preview' => $this->getOption('gtm_server_preview_header')
			],
			'data_format' => 'body',
		];
		wp_remote_post(implode('/', [$url, $path]), $args);
	}
}
