<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */

?>
<div class="cats main-content">
	<div class="shop__cats">
        <?php wp_list_categories( array('taxonomy' => 'product_cat', 'title_li'  => '') ); ?>
    </div>

	<?php
		global $wp_query;
		global $paged;
		$cat = $wp_query->get_queried_object();
		$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
		$image = wp_get_attachment_url( $thumbnail_id );
	?>
	<?php do_action( 'woocommerce_before_main_content' ); ?>
	<div class="woocommerce-products-header" style="--bg-img: url('<?php echo str_replace("'", "\'", $image); ?>');">
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
		<?php endif; ?>
	
		<?php
		/**
		 * Hook: woocommerce_archive_description.
		 *
		 * @hooked woocommerce_taxonomy_archive_description - 10
		 * @hooked woocommerce_product_archive_description - 10
		 */
		do_action( 'woocommerce_archive_description' );
		?>
	</div>

	<?php echo do_shortcode('[yith_wcan_filters slug="default-preset"]'); ?>

<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
//do_action( 'woocommerce_sidebar' );
?>

<?php if($paged<2) : ?>
	<div class="cats__bottom">
		<h3><?php echo get_field('bottom_title', $cat); ?></h3>
		<div><?php echo get_field('bottom_text', $cat); ?></div>
	</div>
<?php endif; ?>

	<div class="shop__bottom">
        <?php $vignettes = get_field('footer_shop_vignettes', 'option'); ?>
        <?php if(!is_null($vignettes) && !empty($vignettes) && is_array($vignettes)) : ?>
            <div class="shop__bottom__flex">
                <?php foreach($vignettes as $v) : ?>
                    <div class="shop__bottom__flex__item">
                        <div class="shop__bottom__flex__item__picto">
                            <img src="<?php echo str_replace('"', '\"', $v['picto']); ?>" alt="<?php echo str_replace('"', '\"', $v['text']); ?>">
                        </div>
                        <div class="shop__bottom__flex__item__text">
                            <?php echo $v['text']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <h2><?php echo get_field('footer_shop_title', 'option'); ?></h2>
        <?php get_template_part('template-parts/phone-number'); ?>
    </div>
</div>

<?php
get_footer( 'shop' );
