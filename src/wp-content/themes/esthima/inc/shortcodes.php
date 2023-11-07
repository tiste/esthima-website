<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


function mon_partial($atts) {
	ob_start();
	get_template_part('partials/mon-partial');
	return ob_get_clean();
}
add_shortcode('mon_partial', 'mon_partial');


function template_partial($atts) {
	extract(shortcode_atts(array(
		'dir' => 'partials',
		'name' => FALSE
	), $atts));
	if ( $name ) {
		ob_start();
		get_template_part( $dir . '/' . $name );
		return ob_get_clean();
	}
}
add_shortcode('partial', 'template_partial');

add_shortcode('pets-configurator', function($atts) {
	wp_enqueue_script( 'petsConfigurator', get_stylesheet_directory_uri() . '/js/petsConfigurator.js', array(), false, true );
	ob_start();
	echo "<div id='petsConfigurator'></div>";
	return ob_get_clean();
});