<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 

/*
* Template Name: Shop HP
*/
get_header('shop');
?>

<main class="main main-content">

    <?php $cats = get_field('cats_blocks'); ?>
    <?php if(!is_null($cats) && !empty($cats) && is_array($cats)) : ?>
    <div class="shop__blocks">
        <?php foreach($cats as $key => $c) : ?>
            <div class="shop__blocks__item <?php echo ($key%2 == 0) ? 'shop__blocks__item-odd' : 'shop__blocks__item-even'; ?>">
                <img src="<?php echo $c['img']; ?>" alt="<?php echo $c['surtitle']; ?> <?php echo $c['title']; ?>" class="shop__blocks__item__img">
                <div class="shop__blocks__item__texts">
                    <h2><?php echo $c['surtitle']; ?> <span><?php echo $c['title']; ?></span></h2>
                    <div class="shop__blocks__item__texts__text">
                        <?php echo $c['text']; ?>
                    </div>
                    <?php if(!is_null($c['products']) && !empty($c['products']) && is_array($c['products'])) : ?>
                        <div class="shop__blocks__item__texts__products">
                            <?php foreach($c['products'] as $p) : ?>
                                <?php $product = wc_get_product($p); ?>
                                <div class="shop__blocks__item__texts__products__prod">
                                    <div class="shop__blocks__item__texts__products__prod__img">
                                        <?php echo $product->get_image(); ?>
                                    </div>
                                    <div class="shop__blocks__item__texts__products__prod__name"><?php echo $product->get_name(); ?></div>
                                    <div class="shop__blocks__item__texts__products__prod__price"><?php echo $product->get_price_html(); ?></div>
                                    <a href="<?php echo get_the_permalink($p); ?>"></a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <a href="<?php echo get_term_link($c['cat']); ?>" class="btn btn--arrow"><?php echo $c['cta_text']; ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <a href="<?php echo get_the_permalink(intval(get_option('woocommerce_shop_page_id'))); ?>" class="btn btn--arrow shop__all">Tous nos produits</a>

    <div class="shop__solo">
        <h2><?php echo get_field('solo_title'); ?></h2>
        <div class="shop__solo__text">
            <?php echo get_field('solo_text'); ?>
        </div>
        <?php $products = get_field('solo_products'); ?>
        <?php if(!is_null($products) && !empty($products) && is_array($products)) : ?>
            <div class="shop__solo__products">
                <?php foreach($products as $key => $p) : ?>
                    <?php $product = wc_get_product($p); ?>
                    <div class="shop__solo__products__item">
                        <div class="shop__solo__products__item__img">
                            <?php echo $product->get_image(); ?>
                        </div>
                        <div class="shop__solo__products__item__name"><?php echo $product->get_name(); ?></div>
                        <div class="shop__solo__products__item__price"><?php echo $product->get_price_html(); ?></div>
                        <a href="<?php echo get_the_permalink($p); ?>"></a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <a href="<?php echo get_term_link(get_field('solo_cat')); ?>" class="btn btn--arrow"><?php echo get_field('solo_ctatext') ?></a>
    </div>

    <div class="shop__seo">
        <h1><?php echo get_field('seo_title'); ?></h1>
        <div class="shop__seo__text">
            <?php echo get_field('seo_text'); ?>
        </div>
    </div>

</main>

<?php get_footer('shop'); ?>