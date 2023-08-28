<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div class="phone-number">
    <div class="phone-number__pill">
        <div class="phone-number__pill__number">
            <?php echo get_field('global_phone', 'option'); ?>
        </div>
        <div class="phone-number__pill__text">
            Service <br>
            & appel gratuits
        </div>
    </div>
    <div class="phone-number__text">
        <?php echo get_field('global_phone_hours', 'option'); ?>
    </div>
    <a href="tel:<?php echo str_replace('"', '\"', get_field('global_phone', 'option')) ?>" class="phone-number__link"></a>
</div>