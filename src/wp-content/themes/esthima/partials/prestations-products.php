<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div class="shop__solo">
    <?php $products = get_field('products'); ?>
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
    <?php $linkSouvenir = get_field('products_link'); ?>
    <?php if(!is_null($linkSouvenir) && !empty($linkSouvenir) && is_array($linkSouvenir)) : ?>
        <a href="<?php echo $linkSouvenir['url']; ?>" target="<?php echo $linkSouvenir['target']; ?>" class="btn btn--arrow"><?php echo $linkSouvenir['title']; ?></a>
    <?php endif; ?>
</div>