<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 

/*
* Template Name: Contact
*/
get_header();
?>

<main class="main main-content">

    <div class="contact__tet">
        <div class="contact__tet__texts">
            <div class="contact__tet__texts__breadcrumbs">
                <?php if(function_exists('yoast_breadcrumb')){ yoast_breadcrumb(); } ?>
            </div>
            <h1><?php echo get_field('tet_title'); ?></h1>
            <?php get_template_part('template-parts/phone-number'); ?>
            <h3><?php echo get_field('tet_subtitle'); ?></h3>
            <div class="contact__tet__texts__text">
                <?php echo get_field('tet_text'); ?>
            </div>
            <img src="<?php echo str_replace('"', '\"', get_field('tet_img')); ?>" alt="<?php echo str_replace(array('"', '<span>', '</span>'), array('\"', '', ''), get_field('tet_title')); ?>" class="contact__tet__texts__img">
        </div>
        <div class="contact__tet__form">
            <img src="<?php echo get_template_directory_uri(); ?>/images/close-pink.svg" alt="Fermer" class="contact__tet__form__close">
            <h2>Nous contacter</h2>
            <?php echo do_shortcode('[gravityform id="2" title="false" description="false" ajax="true"]'); ?>
        </div>
    </div>
    <div class="contact__tet__form-cta">
        <img src="<?php echo get_template_directory_uri(); ?>/images/email-contact.svg" alt="Contact">
    </div>

    <div class="contact__map">
        <div class="contact__map__texts">
            <h2><?php echo get_field('map_title'); ?></h2>
            <div class="contact__map__texts__text">
                <?php echo get_field('map_text'); ?>
            </div>
        </div>
        <div class="contact__map__map">
            <?php echo do_shortcode('[wpsl]'); ?>
        </div>
    </div>

    <div class="contact__bottom">
        <h2><?php echo get_field('bottom_title'); ?></h2>
        <div class="contact__bottom__text">
            <?php echo get_field('bottom_text'); ?>
        </div>
    </div>

</main>


<?php get_footer(); ?>