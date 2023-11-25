<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 

/*
* Template Name: Notre histoire
*/
get_header();
?>

<main class="main main-content">
    <div class="histoire__tet">
        <div class="histoire__tet__bg">
            <div class="histoire__tet__breadcrumbs">
                <?php if(function_exists('yoast_breadcrumb')){ yoast_breadcrumb(); } ?>
            </div>
            <div class="histoire__tet__container">
                <div class="histoire__tet__texts">
                    <h1><?php echo get_field('tet_title'); ?></h1>
                    <h2><?php echo get_field('tet_subtitle'); ?></h2>
                    <div class="histoire__tet__texts__text">
                        <?php echo get_field('tet_text'); ?>
                    </div>
                </div>
            </div>
        </div>
        <img src="<?php echo str_replace('"', '\"', get_the_post_thumbnail_url()); ?>" alt="<?php echo str_replace('"', '\"', get_the_title()); ?>" class="histoire__tet__img">
    </div>

    <?php $frise = get_field('chrono'); ?>
    <?php if(!is_null($frise) && !empty($frise) && is_array($frise)) : ?>
    <div class="histoire__frise-container">
        <div class="histoire__frise">
            <?php foreach($frise as $f) : ?>
                <div class="histoire__frise__item">
                    <div class="histoire__frise__item__dot"></div>
                    <div class="histoire__frise__item__year"><?php echo $f['year']; ?></div>
                    <div class="histoire__frise__item__text"><?php echo $f['text']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php $list = get_field('list'); ?>
    <?php if(!is_null($list) && !empty($list) && is_array($list)) : ?>
    <div class="histoire__list">
        <div class="histoire__list__list">
            <?php foreach($list as $l) : ?>
                <div class="histoire__list__list__item">
                    <h3><?php echo $l['title']; ?></h3>
                    <div class="histoire__list__list__item__text"><?php echo $l['text']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <img src="<?php echo str_replace('"', '\"', get_field('list_pic')); ?>" class="histoire__list__img">
    </div>
    <?php endif; ?>

    <?php $bottom = get_field('bottom'); ?>
    <?php if(!is_null($bottom) && !empty($bottom) && is_array($bottom)) : ?>
    <div class="histoire__bottom">
        <?php foreach($bottom as $b) : ?>
            <div class="histoire__bottom__item">
                <h3><?php echo $b['title']; ?></h3>
                <div class="histoire__bottom__item__text"><?php echo $b['text']; ?></div>
                <?php if(!is_null($b['link']) && !empty($b['link']) && is_array($b['link'])) : ?>
                    <a href="<?php echo str_replace('"', '\"', $b['link']['url']); ?>" target="<?php echo str_replace('"', '\"', $b['link']['target']); ?>" class="histoire__bottom__item__btn btn btn--arrow"><?php echo $b['link']['title']; ?></a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</main>


<?php get_footer(); ?>