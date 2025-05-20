<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 

/*
* Template Name: Landing 1
*/
get_header("landing");
?>

<main class="main main-landing">
    <div class="wrap wrap--lg landing__container">

    <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

        <div class="landing__bg">

            <div class="the-content landing__content">
                <?php the_content() ?>
            </div>

        </div>
            
        <?php endwhile; ?>

    <?php endif; ?>
        
    </div>
</main>


<?php get_footer("landing"); ?>