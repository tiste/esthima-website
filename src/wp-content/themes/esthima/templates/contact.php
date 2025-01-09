<?php if (!defined("ABSPATH")) {
    exit();
} // Exit if accessed directly

/*
 * Template Name: Contact
 */
get_header();
?>

<main class="main main-content">

	<div class="contact__tet">
        <div class="contact__tet__texts">
            <div class="contact__tet__texts__breadcrumbs">
                <?php if (function_exists("yoast_breadcrumb")) {
                    yoast_breadcrumb();
                } ?>
            </div>
            <h1><?php echo get_field("tet_title"); ?></h1>
            <?php get_template_part("template-parts/phone-number"); ?>
            <h3><?php echo get_field("tet_subtitle"); ?></h3>
            <div class="contact__tet__texts__text">
                <?php echo get_field("tet_text"); ?>
            </div>
            <img src="<?php echo str_replace(
                '"',
                '\"',
                get_field("tet_img")
            ); ?>" alt="<?php echo str_replace(
    ['"', "<span>", "</span>"],
    ['\"', "", ""],
    get_field("tet_title")
); ?>" class="contact__tet__texts__img">
        </div>
        <div class="contact__tet__form" style="max-width:500px">
            <h2>Nous contacter</h2>
			<?php echo do_shortcode('[gravityform id="1" title="false"]'); ?>
		</div>
	</div>

</main>

<?php
get_footer();