<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Register and load the widgets
function k_load_static_include_template() {

	// ADD HERE YOUR CUSTOM "STATIC" WIDGETS

	// EXAMPLE
    /*register_widget(
		new k_widget("[ID DU WIDGET]", "[NOM DU WIDGET]", "[NOM DU TEMPLATE .PHP DANS LE DOSSIER /PARTIALS DU THEME]", "[MESSAGE AFFICHÉ DANS L'ADMIN DU WIDGET]")
    );*/
    
}
add_action( 'widgets_init', 'k_load_static_include_template' );


// Creating the widget "k_widget" (common widget for static partials template)
class k_widget extends WP_Widget {
	function __construct($widget_id, $widget_name, $template_name, $admin_form_message) {
		parent::__construct(
			$widget_id, 
			$widget_name
		);
		$this->template_name = $template_name;
		$this->admin_form_message = $admin_form_message;
	}

	// admin form
	public function form( $instance ) { ?>
		<i class="eicon-info-circle" style="font-size: 50px;"></i>
		<p><?php echo $this->admin_form_message; ?></p>
	<?php }

	// Creating widget front-end
	public function widget( $args, $instance ) {
		get_template_part('partials/'.$this->template_name);
	}
} // Class k_widget ends here
