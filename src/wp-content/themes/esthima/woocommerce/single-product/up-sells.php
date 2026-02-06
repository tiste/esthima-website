<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
    <section class="up-sells upsells products">
        <h2>Complétez votre commande</h2>

        
		<?php woocommerce_product_loop_start(); ?>

			<?php while ($souvenirs->have_posts()) : $souvenirs->the_post(); ?>

				<?php
				$post_object = get_post( get_the_ID() );

				setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

				wc_get_template_part( 'content', 'product' );
				?>

			<?php endwhile; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>
<?php endif; wp_reset_postdata();

if ( $upsells ) : ?>

	<section class="up-sells upsells products">
		<?php
		$heading = apply_filters( 'woocommerce_product_upsells_products_heading', __( 'Cela pourrait également vous intéresser', 'woocommerce' ) );

		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $upsells as $upsell ) : ?>

				<?php
				$post_object = get_post( $upsell->get_id() );

				setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

				wc_get_template_part( 'content', 'product' );
				?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>

	<?php
endif;

wp_reset_postdata();