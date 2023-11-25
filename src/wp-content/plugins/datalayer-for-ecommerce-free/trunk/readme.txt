=== Datalayer for WooCommerce FREE ===
Contributors: arraycodes, heitor_tito, arrayevida
Donate link: https://array.codes
Tags: datalayer, gtm tag manager, analytics, ua, ga4, universal analytics
Requires at least: 5.2.0
Tested up to: 6.2.2
Stable tag: 3.0.0
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

== Description ==

The Data Layer is an object that makes available in real time the information that is executed by users while browsing the WooCommerce Store.

With Datalayer for WooCommerce FREE enabled, you will have some actions available in an easily readable javascript object via Google Tag Manager or code and thus evaluate the following advanced eCommerce activities:

1. Product Detail Impressions
2. Purchases

<b>Need all available events, all tags (UA, GA4, Ads, Facebook, Pinterest and TikTok), all features and support for all tools?</b>
Get the PRO version from the Official WooCommerce Store: <a href="https://woocommerce.com/products/datalayer-for-woocommerce/" target="_blank">Datalayer for WooCommerce PRO</a>

<b>Discover our demo store:</b>
<a href="https://demoshop.arrayevida.com.br/" target="_blank">Demo Shop</a>

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/datalayer-for-ecommerce-free` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the WooCommerce > Datalayer for WooCommerce -> screen to configure the plugin

= Configuration =

<b>Google Tag Manager ID</b> -> Enter the GTM-XXXXXX ID to activate the Google Tag Manager code snippet
<b>DataLayer for WooCommerce Enhanced Ecommerce</b> -> Enable this option if you use <a href="https://developers.google.com/analytics/devguides/collection/ua/gtm/enhanced-ecommerce" target="_blank">Google Analytics UA</a> with <a href="https://support.google.com/analytics/answer/9744165" target="_blank">Google Analytics 4 (GA4) tags as a complement to UA</a>
<b>DataLayer for WooCommerce Ecommerce GA4</b> -> Enable this option if you use only <a href="https://developers.google.com/analytics/devguides/collection/ga4/ecommerce?client_type=gtm" target="_blank">Google Analytics 4 (GA4)</a>
<b>Show user info</b> -> Select if user information show or not when logged

= Import Google Tag Manager =

1. Download the workspace.zip file in WooCommerce > Datalayer for WooCommerce > Download import File GTM.
2. Go to Google Tag Manager > Admin > Import Container
3. Select the file you want to import:
	GTM-UA-with-GA4-complement-FREE.json  -> If you want to use Analytics UA tags and variables, GA4 as a complement.
	GTM-GA4-FREE.json -> If you want to use only Analytics GA4 tags and variables.
4. After selecting the file, import the tags.


= Settings Universal Analytics with Google Analytics 4 tags as a complement =

1. In GTM, go to the variables menu and add your Google Analytics UA and click save.
2. In GTM, go to the tag GA4 – Tag and add your measurement id and click save.


= Settings Google Analytics 4 =

1. In GTM, go to the Tags menu and select the tag GA4 – Tag, enter the id of your GA4 and click on save.

== Screenshots ==

1. Google Tag Manager Settings screen plugin.
2. Ecommerce Settings screen plugin.
3. Ecommerce Advanced screen plugin.
4. Tags Universal Analytics with Google Analytics 4 tags as a complement imported
5. Tags Google Analytics 4 imported

== Changelog ==
= 3.0.0 - 2023-10-30 =
* New: Full compatibility with WooCommerce Blocks
* New: New Modern Admin Page
* Support: Support -> WP 6.3.2 WC 8.2.1

= 2.7.0 - 2023-06-21 =
* New: Select if user information show or not when logged
* New: Full Compatibility HPOS - High-Performance order storage (COT)
* Support: Support -> WP 6.2.2 WC 7.8.0

= 2.4.0 - 2023-03-29 =
* Support: Support -> WP 6.1.1 WC 7.5.1
* Update: optimization and improvement of the code that triggers the events

= 2.0.2 - 2022-09-21 =
* Support: WP 6.0.2 WC 6.9.3
* Fix: Multisite full support check WooCommerce Active

= 2.0.0 - 2022-06-22 =
* First Release
