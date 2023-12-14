<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php $steps = get_field('steps'); ?>
<?php if(!is_null($steps) && !empty($steps) && is_array($steps)) : ?>
    <div class="steps-death">
        <h2><?php echo get_field('steps_title'); ?></h2>
        <div class="steps-death__flex">
            <div class="steps-death__flex__texts">
                <?php foreach($steps as $k => $s) : ?>
                    <div class="steps-death__flex__texts__item">
                        <div class="steps-death__flex__texts__item__top">
                            <div class="steps-death__flex__texts__item__top__picto">
                                <img src="<?php echo str_replace('"', '\"', $s['picto']); ?>" alt="Etape <?php echo $k+1; ?> - <?php echo str_replace('"', '\"', $s['title']); ?>">
                            </div>
                            <div class="steps-death__flex__texts__item__top__title">
                                étape <?php echo $k+1; ?>
                            </div>
                            <div class="steps-death__flex__texts__item__top__text">
                                <?php echo $s['title']; ?>
                            </div>
                        </div>
                        <div class="steps-death__flex__texts__item__text">
                            <?php echo $s['text']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <img src="<?php echo str_replace('"', '\"', get_field('steps_img')); ?>" alt="<?php echo str_replace('"', '\"', get_field('steps_title')); ?>" class="steps-death__flex__img">
        </div>
    </div>
<?php endif; ?>