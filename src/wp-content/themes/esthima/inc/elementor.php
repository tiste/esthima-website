<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/* is page built with elementor ? */
function is_elementor(){
  global $post;
  return \Elementor\Plugin::$instance->db->is_built_with_elementor($post->ID);
}
