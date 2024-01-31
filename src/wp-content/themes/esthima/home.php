<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 

get_header();
?>



<main class="main main-content">

<?php
$pageTitle = get_field('tet_title', intval(get_option('page_for_posts')));
$pageSubtitle = get_field('tet_subtitle', intval(get_option('page_for_posts')));
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$argsSticky = array(
    'post_type' => 'post',
    'posts_per_page' => 1,
    'ignore_sticky_posts' => false
);
$querySticky = get_posts($argsSticky);
$argsRegular = array(
    'post_type' => 'post',
    'posts_per_page' => 8,
    'post__not_in' => array($querySticky[0]->ID),
    'paged' => $paged,
    'ignore_sticky_posts' => true
);
$queryRegular = new WP_Query($argsRegular);
?>

    <div class="guides__tet">
        <div class="lightBG"></div>
        <div class="guides__tet__breadcrumbs">
            <?php if(function_exists('yoast_breadcrumb')){ yoast_breadcrumb(); } ?>
        </div>
        <div class="guides__tet__texts">
            <h1><?php echo $pageTitle; ?></h1>
            <div class="guides__tet__texts__text"><?php echo $pageSubtitle; ?></div>
        </div>
        <div class="guides__tet__sticky" style="--bg-img: url('<?php echo str_replace("'", "\'", get_the_post_thumbnail_url($querySticky[0]->ID)); ?>')">
            <div class="guides__tet__sticky__cat">
                <?php
                    $mainCat = yoast_get_primary_term_id( 'guide_cat', $querySticky[0]->ID );
                    if($mainCat){
                        echo get_term($mainCat)->name;
                    }else{
                        echo get_the_term_list($querySticky[0]->ID, 'guide_cat', '', ', ', '');
                    }
                ?>
            </div>
            <div class="guides__tet__sticky__title">
                <?php echo get_the_title($querySticky[0]->ID); ?>
            </div>
            <a href="<?php echo get_the_permalink($querySticky[0]->ID); ?>" class="btn btn--arrow">Lire l'article</a>
        </div>
    </div>

    <?php
        // $cats = get_terms( array(
        //     'taxonomy' => 'category',
        //     'hide_empty' => true,
        //     'hierarchical' => true,
        //     'parent' => 0,
        //     'exclude' => array(1)
        // ) );
    ?>
    <?php //if(!is_null($cats) && !empty($cats) && is_array($cats)) : ?>
    <!-- <div class="guides__cats">
        <a href="<?php //echo home_url('/'); ?>actualites" class="active">Tous les articles</a>
        <?php //foreach($cats as $c) : ?>
            <a href="<?php //echo get_term_link($c); ?>"><?php //echo $c->name; ?></a>
        <?php //endforeach; ?>
    </div> -->
    <?php //endif; ?>

    <!-- <select class="guides__cats-mob">
        <option value="<?php //echo str_replace('"', '\"', home_url('/')); ?>actualites" selected>Tous les articles</option>
        <?php //if(!is_null($cats) && !empty($cats) && is_array($cats)) : ?>
            <?php //foreach($cats as $c) : ?>
                <option value="<?php //echo str_replace('"', '\"', get_term_link($c)); ?>"><?php //echo $c->name; ?></option>
            <?php //endforeach; ?>
        <?php //endif; ?>
    </select> -->

    <div class="guides__posts">
        <?php if ( $queryRegular->have_posts() ) : $i = 0; ?>
            <?php while ( $queryRegular->have_posts() ) : $queryRegular->the_post(); ?>
                <div class="guides__posts__item <?php echo ($i==0 || $i==5 || $i==6) ? 'guides__posts__item-big guides__posts__item-'.$i : 'guides__posts__item-'.$i; ?>">
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>" class="guides__posts__item__img">
                    <div class="guides__posts__item__texts">
                        <div class="guides__posts__item__cat">
                            <?php
                                $mainCat = yoast_get_primary_term_id( 'guide_cat', get_the_ID() );
                                if($mainCat){
                                    echo get_term($mainCat)->name;
                                }else{
                                    echo get_the_term_list(get_the_ID(), 'guide_cat', '', ', ', '');
                                }
                            ?>
                        </div>
                        <div class="guides__posts__item__title">
                            <?php echo get_the_title(); ?>
                        </div>
                        <a href="<?php echo get_the_permalink(); ?>" class="btn">Lire l'article</a>
                    </div>
                </div>
                <?php if( ($queryRegular->current_post + 1) == ($queryRegular->post_count) ) : ?>
                <div class="guides__posts__newsletter guides__posts__newsletter-<?php echo $i; ?>">
                    <div class="guides__posts__newsletter__title">Restez informés en vous inscrivant à notre newsletter !</div>
                    <div class="guides__posts__newsletter__form">
						<div>
                        <form action="<?php echo home_url("inscription-a-la-newsletter"); ?>" method="GET">
							<input type="email" name="email" placeholder="Votre adresse email">
							<input type="submit">
                        </form>
						</div>
						<div class="guides__posts__newsletter__form__check">
							<input type="checkbox" id="newsletterconsent" name="newsletterconsent">
							<label for="newsletterconsent">J’accepte de m’inscrire à la newsletter et je reconnais avoir pris connaissance de la politique de confidentialité d’Esthima.</label>
						</div>
					</div>
                </div>
                <?php endif; ?>
                <?php $i++; ?>
            <?php endwhile; wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="guides__posts__nothing">
                Désolé, aucun article ne correspond à votre recherche.
            </div>
        <?php endif; ?>    
    </div>

    <?php if ( $queryRegular->have_posts() ) : ?>
        <div class="guides__pagination">
            <?php
            echo paginate_links(array(
                // 'format' => '?page=%#%',
                'total'     => $queryRegular->max_num_pages,
                'current'   => $paged,
                'prev_text' => '&laquo; Previous',
                'next_text' => 'Next &raquo;',
                'mid_size'           => 2,
            ));
            ?>
        </div>
    <?php endif; ?>

    

</main>


<?php get_footer(); ?>