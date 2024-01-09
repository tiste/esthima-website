<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 

/*
* Template Name: Panier
*/
get_header('shop');
?>

<main class="main main-content panier">
    <div class="panier__top">
        <div class="panier__top__breadcrumbs">
            <a href="<?php echo home_url('/'); ?>boutique">Boutique</a>
            >
            Panier
        </div>
        <h1>Mon panier <span>/ <?php echo WC()->cart->get_cart_contents_count(); echo (WC()->cart->get_cart_contents_count()>1) ? ' articles' : ' article'; ?> </span></h1>
        <?php the_content(); ?>
        <div class="back-container">
            <a href="<?php echo home_url('/'); ?>boutique/" class="panier__top__back">Continuer mes achats</a>
        </div>
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
		</div>
    </div>
    <div class="panier__bottom">
        <?php
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

                        setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                        wc_get_template_part( 'content', 'product' );
                        ?>
			        <?php endwhile; ?>
		        <?php woocommerce_product_loop_end(); ?>
	        </section>
        <?php endif; wp_reset_postdata(); ?>
    </div>
</main>

<?php get_footer(); ?>