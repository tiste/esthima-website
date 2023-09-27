<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 

/*
* Template Name: Espace presse
*/
get_header();
?>

<main class="main main-content">

    <div class="presse__tet">
        <div class="presse__tet__bg">
            <div class="presse__tet__breadcrumbs">
                <?php if(function_exists('yoast_breadcrumb')){ yoast_breadcrumb(); } ?>
            </div>
            <div class="presse__tet__container">
                <div class="presse__tet__texts">
                    <h1><?php echo get_field('tet_title'); ?></h1>
                    <div class="presse__tet__texts__text">
                        <?php echo get_field('tet_text'); ?>
                    </div>
                </div>
            </div>
        </div>
        <img src="<?php echo str_replace('"', '\"', get_the_post_thumbnail_url()); ?>" alt="<?php echo str_replace('"', '\"', get_the_title()); ?>" class="presse__tet__img">
    </div>

    <?php $links = get_field('links'); ?>
    <?php if(!is_null($links) && !empty($links) && is_array($links)) : ?>
    <div class="presse__links">
        <?php foreach($links as $l) : ?>
            <div class="presse__links__item">
                <img src="<?php echo str_replace('"', '\"', $l['picto']); ?>" alt="<?php echo str_replace('"', '\"', $l['text']); ?>" class="presse__links__item__picto">
                <div class="presse__links__item__text">
                    <?php echo $l['text']; ?>
                </div>
                <?php if(!empty($l['help'])) : ?>
                <div class="presse__links__item__help">
                    <?php echo $l['help']; ?>
                </div>
                <?php endif; ?>
                <a href="<?php echo ($l['type']=='dl') ? $l['file'] : $l['page']; ?>"></a>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php
        $pagedPresse = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $argsPresse = array(
            'post_type' => 'espace-presse',
            'posts_per_page' => 6,
            'paged' => $pagedPresse
        );
        $queryPresse = new WP_Query($argsPresse);
    ?>
    <?php if($queryPresse->have_posts()) : ?>
        <div class="presse__posts">
            <div class="presse__posts__grid">
                <?php while ($queryPresse->have_posts()) : $queryPresse->the_post(); ?>
                    <div class="presse__posts__grid__item">
                        <img src="<?php echo str_replace('"', '\"', get_the_post_thumbnail_url()); ?>" alt="<?php echo str_replace('"', '\"', get_the_title()); ?>" class="presse__posts__grid__item__img">
                        <div class="presse__posts__grid__item__texts">
                            <div class="presse__posts__grid__item__texts__source">
                                <?php echo get_field('source'); ?>
                            </div>
                            <div class="presse__posts__grid__item__texts__title">
                                <?php echo get_the_title(); ?>
                            </div>
                            <div class="presse__posts__grid__item__texts__date">
                                <?php echo get_field('date'); ?>
                            </div>
                            <a href="<?php echo str_replace('"', '\"', get_field('link')); ?>" class="presse__posts__grid__item__texts__link" target="_blank" rel="nofollow">Lire l'article</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="presse__posts__pagination">
            <?php
                echo paginate_links(array(
                    'format' => '?page=%#%',
                    'total'     => $queryPresse->max_num_pages,
                    'current'   => $pagedPresse,
                    'prev_text' => '&laquo; Previous',
                    'next_text' => 'Next &raquo;',
                    'mid_size'           => 2,
                ));
                ?>
            </div>
        </div>
    <?php endif; wp_reset_postdata(); ?>


</main>


<?php get_footer(); ?>