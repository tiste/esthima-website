<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 

/*
* Template Name: FAQ
*/
get_header();
?>

<main class="main main-content page-faq">

    <div class="page-faq__container">
	
        <?php if ( have_posts() ) : ?>

            <?php while ( have_posts() ) : the_post(); ?>

            <div class="page-faq__bg">

                <div class="page-faq__content">
                    <?php the_content() ?>
                </div>

                <?php echo do_shortcode("[partial name='list-faq']"); ?>

            </div>
                
            <?php endwhile; ?>

        <?php endif; ?>
        
    </div>

</main>

<?php get_footer(); ?>