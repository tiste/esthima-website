<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php 
				global $product;
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->id ), 'single-post-thumbnail' );
			
				echo '<div itemscope itemtype="http://schema.org/Product">
				<link itemprop="url" href="' . get_the_permalink($product->id) . '" />
				<meta itemprop="name" content="' . $product->get_name() . '" />
				<link itemprop="image" href="' . $image[0] . '" />
				<meta itemprop="brand" content="Esthima" />
				<meta itemprop="sku" content="' . $product->get_sku() . '" />
				<meta itemprop="description" content="' . htmlspecialchars($product->get_description()) . '" />
				</div>';
			
				echo '<div itemscope itemtype="https://schema.org/Offer">
				<link itemprop="availability" href="https://schema.org/InStock" />
				<meta itemprop="url" content="' . get_the_permalink($product->id) . '" />
				<meta itemprop="priceCurrency" content="EUR" />
				<meta itemprop="price" content="' . $product->get_price() . '" />
				</div>';
			?>
			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		//do_action( 'woocommerce_sidebar' );
	?>

<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
