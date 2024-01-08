<?php

namespace GtmEcommerceWooPro\Lib\Service;

use GtmEcommerceWoo\Lib\Service\SettingsService as FreeSettingsService;

/**
 * Logic related to working with settings and options
 */
class SettingsService extends FreeSettingsService {

	const SETTING_NAME_EVENT_BROWSER_PURCHASE_ONLY_ON_THANK_YOU_PAGE = 'event_browser_purchase_only_on_thank_you_page';

	protected $uuidPrefix = 'gtm-ecommerce-woo-pro';

	protected $allowServerTracking = true;

	protected $filter = 'advanced';

	protected $eventsConfig = [
		'abandon_cart' => [
			'default_disabled' => true,
			'description' => 'Fires on cart summary page after tab/browser close.',
		],
		'abandon_checkout' => [
			'default_disabled' => true,
			'description' => 'Fires on checkout form page after tab/browser close.',
		]
	];

	public function settingsInit() {
		parent::settingsInit();

		$this->wpSettingsUtil->addSettingsSection(
			'browser_events_settings',
			'Web Events Settings',
			'',
			'settings'
		);

		$this->wpSettingsUtil->addSettingsField(
			self::SETTING_NAME_EVENT_BROWSER_PURCHASE_ONLY_ON_THANK_YOU_PAGE,
			'Track purchase event only on thank you page?',
			[$this, 'checkboxField'],
			'browser_events_settings',
			'If unchecked, purchase will be tracked before payment gateway redirection, just after order is created in WordPress database. Note that <strong>checking this option can reduce the number of tracked purchase events</strong>, as tracking requires the customer to return to the store after payment, which is not always the case.'
		);
	}
}
