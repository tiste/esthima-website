<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 
?>
<?php
/*
* Template Name: Store locator
*/
get_header();
?>



<main class="main">

    <div class="storeloc__tet" style="--bg-img: url('<?php echo get_the_post_thumbnail_url(); ?>')">
        <div class="storeloc__tet__breadcrumbs">
            <?php if(function_exists('yoast_breadcrumb')){ yoast_breadcrumb(); } ?>
        </div>
        <h2>AGENCES ET CRÉMATORIUMS POUR ANIMAUX</h2>
        <h1>Trouvez une agence près de chez vous</h1>
        <div class="storeloc__tet__text">
            Esthima dispose de centres de crémation et agences funéraires partout en France.
        </div>
        <div class="storeloc__tet__form">
            <input type="text" placeholder="Votre code postal">
            <div class="btn btn--arrow">
                Trouver
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="storeloc__map">
            <?php echo do_shortcode('[wpsl]'); ?>
        </div>
    
        <div class="storeloc__content">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

</main>

<?php get_footer(); ?>