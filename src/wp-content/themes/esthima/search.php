<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	get_header();
?>

<?php
$args = array(
    'post_type' => array(
        'page', 'post', 'guide', 'product'
    ),
    'posts_per_page' => -1,
    'ignore_sticky_posts' => true,
    'orderby' => 'relevance',
    's' => $s
);
$the_query = new WP_Query( $args );
?>

<main class="main main-content">
    <div class="results-search">
        <?php if ( $the_query->have_posts() ) : ?>
            <h1>Résultats pour : <span><?php echo $s; ?></span></h1>
            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div class="results-search__item">
                    <?php
                        $postTypeStr = "Page";
                        if(get_post_type()=='post'){
                            $postTypeStr = "Actualités";
                        }elseif(get_post_type()=='guide'){
                            $postTypeStr = "Guides & conseils";
                        }elseif(get_post_type()=='product'){
                            $postTypeStr = "Produit";
                        }
                    ?>
                    <h3><span><?php echo $postTypeStr; ?></span> : <?php echo get_the_title(); ?></h3>
                    <div class="results-search__item__texts__excerpt">
                        <?php echo get_the_excerpt(); ?>
                    </div>
                    <a href="<?php echo str_replace('"', '\"', get_the_permalink()); ?>">Voir plus</a>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <h1>Désolé, nous n'avons rien trouvé pour <span><?php echo $s; ?></span></h1>
        <?php endif; wp_reset_postdata(); ?>
    </div>
</main>

<?php get_footer(); ?>
