<?php
/**
 * Admin Page
 *
 * @package datalayer
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap">
	<!--suppress HtmlUnknownTarget -->
	<form method="POST" action="options.php">
		<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
		<div id="poststuff" class="metabox-holder has-right-sidebar">
			<div class="inner-sidebar">
				<div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position:relative;">
					<div id="sm_pnres" class="postbox">
						<h3 class="hndle"><span><?php esc_html_e( 'About of Plugin:', 'datalayer-for-ecommerce-free' ); ?></span></h3>
						<div class="inside">
							<br>
							<a class="button activate-now button-primary" target="_blank" href="https://wordpress.org/plugins/datalayer-for-ecommerce-free/" style="font-size:18px;display: block;text-align: center;">
								<?php esc_html_e( 'RATE US', 'datalayer-for-ecommerce-free' ); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="has-sidebar sm-padded">
				<div id="post-body-content" class="has-sidebar-content">
					<div class="meta-box-sortabless">
						<div id="sm_rebuild" class="postbox">
							<h3 class="hndle"><span><?php esc_html_e( 'DataLayer for WooCommerce FREE', 'datalayer-for-ecommerce-free' ); ?></span></h3>
							<div class="inside" style="display: grid;">
								<?php
								settings_fields( 'datalayer-for-ecommerce-free' );
								do_settings_sections( 'datalayer-for-ecommerce-free' );
								submit_button();
								?>
							</div>
						</div>
						<div class="postbox">
							<h3 class="hndle"><span><?php esc_html_e( 'Extra Settings:', 'datalayer-for-ecommerce-free' ); ?></span></h3>
							<div class="inside">
								<br/>
								<a rel="noopener noreferrer nofollow" target="_blank" href="<?php echo esc_url( 'https://demoshop.arrayevida.com.br/wp-content/uploads/2022/06/workspace.zip' ); ?>"><div id="" class="button button-primary"><?php esc_html_e( 'Download Import File GTM', 'datalayer-for-ecommerce-free' ); ?></div></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
