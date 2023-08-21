<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* enqueue JS specific to page */
add_filter( 'template_include', function($template){

	// if( basename( $template ) == 'mon-compte.php' ) {
	// 	wp_enqueue_script( 'ihc-print-this', IHC_URL . 'assets/js/printThis.js', ['jquery'], 10.2 );
	// }

	// if ( strpos( $_SERVER[ 'REQUEST_URI' ], MAP_URLS['REGISTER'] ) !== false) {
	// 	wp_enqueue_script( 'formPayment', get_stylesheet_directory_uri() . '/js/formPayment.js', array(), filemtime(  get_template_directory() . '/js/formPayment.js' ), true );
	// }
	
	return $template;
}, 99 );



/* add the 'Lost Password" link to the login form */
add_action( 'login_form_middle', 'add_lost_password_link' );
function add_lost_password_link() {
	return '<a class="s-login-form__reset-password" href="/wp-login.php?action=lostpassword">J\'ai oublié mon mot de passe</a>';
}



/* Fix Select2 issues with WordPress Admin Bar */
add_action( 'wp_head', 'smyles_output_select2_admin_bar_fix' );
function smyles_output_select2_admin_bar_fix() {
	$type_attr = current_theme_supports( 'html5', 'style' ) ? '' : ' type = "text/css"';
	
	/**
	 * We use ~ here instead of + for any situations where something else ends up attaching to body as well
	 */
	?>
	<style<?php echo $type_attr; ?> media="screen">
		div#wpadminbar ~ span.select2-container, body.admin-bar > span.select2-container {
			padding-top: 32px !important;
		}

		@media screen and ( max-width: 782px ) {
			div#wpadminbar ~ span.select2-container, body.admin-bar > span.select2-container {
				padding-top: 46px !important;
			}
		}
	</style>
	<?php
}

