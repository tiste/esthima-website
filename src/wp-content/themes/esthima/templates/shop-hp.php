<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 

/*
* Template Name: Shop HP
*/
get_header();
?>

<main class="main main-content">

    <div class="shop__cats">
        <?php wp_list_categories( array('taxonomy' => 'product_cat', 'title_li'  => '') ); ?>
    </div>

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
                                    <div class="shop__blocks__item__texts__products__prod__price">Dès <?php echo $product->get_price_html(); ?></div>
                                    <a href="<?php echo get_the_permalink($p); ?>"></a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <a href="<?php echo get_term_link($c['cat']); ?>" class="btn btn--arrow">Découvrir la collection</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

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
                        <div class="shop__solo__products__item__price">Dès <?php echo $product->get_price_html(); ?></div>
                        <a href="<?php echo get_the_permalink($p); ?>"></a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <a href="<?php echo get_term_link(get_field('solo_cat')); ?>" class="btn btn--arrow"><?php echo get_field('solo_ctatext') ?></a>
    </div>

    <div class="shop__bottom">
        <?php $vignettes = get_field('bottom_vignettes'); ?>
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
        <h2><?php echo get_field('bottom_title'); ?></h2>
        <?php get_template_part('template-parts/phone-number'); ?>
    </div>

</main>

<?php get_footer(); ?>