<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 

/*
* Template Name: Espace recrutement
*/
get_header();
?>

<main class="main main-content">
    <div class="jobs__tet">
        <div class="jobs__tet__bg">
            <div class="jobs__tet__breadcrumbs">
                <?php if(function_exists('yoast_breadcrumb')){ yoast_breadcrumb(); } ?>
            </div>
            <div class="jobs__tet__container">
                <div class="jobs__tet__texts">
                    <h1><?php echo get_field('tet_title'); ?></h1>
                    <div class="jobs__tet__texts__text">
                        <?php echo get_field('tet_text'); ?>
                    </div>
                </div>
            </div>
        </div>
        <img src="<?php echo str_replace('"', '\"', get_the_post_thumbnail_url()); ?>" alt="<?php echo str_replace('"', '\"', get_the_title()); ?>" class="presse__tet__img">
    </div>

    <div class="jobs__jobs">
        <h2><?php echo get_field('jobs_title'); ?></h2>
        <hr>
        <?php echo get_field('jobs_script'); ?>
    </div>

    <div class="jobs__self">
        <h2><?php echo get_field('self_title'); ?></h2>
        <div class="jobs__self__btn btn btn--arrow"><?php echo get_field('self_btn'); ?></div>
        <div class="jobs__self__form-container">
            <div class="jobs__self__form">
                <?php $gfID = get_field('self_gf'); echo do_shortcode('[gravityform id="'.$gfID.'" title="false" description="false" ajax="true"]'); ?>
            </div>
        </div>
    </div>
</main>


<?php get_footer(); ?>