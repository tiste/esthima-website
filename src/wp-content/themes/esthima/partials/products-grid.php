<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

    $argsSouv = array(
        'post_type' => 'product',
        'ignore_sticky_posts' => false,
        'posts_per_page' => 5,
        'product_cat' => 'urnes-animaux-reliquaires',
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand'
    );
    $souvenirs = new WP_Query($argsSouv);
?>

<?php if($souvenirs->have_posts()) : ?>
    <section class="grid-souvenirs">
		<?php woocommerce_product_loop_start(); ?>

			<?php while ($souvenirs->have_posts()) : $souvenirs->the_post(); ?>

				<?php
				$post_object = get_post( get_the_ID() );

				setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

				wc_get_template_part( 'content', 'product' );
				?>

			<?php endwhile; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>
<?php endif; wp_reset_postdata(); ?>