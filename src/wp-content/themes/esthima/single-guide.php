<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	get_header();
?>

<main class="main main-content">

    <div class="guide__tet">
        <div class="lightBG"></div>
        <div class="guide__tet__breadcrumbs">
            <?php if(function_exists('yoast_breadcrumb')){ yoast_breadcrumb(); } ?>
        </div>
        <div class="guide__tet__flex">
            <div class="guide__tet__flex__img">
                <img src="<?php echo str_replace('"', '\"', get_the_post_thumbnail_url()); ?>" alt="<?php echo str_replace('"', '\"', get_the_title()); ?>">
            </div>
            <div class="guide__tet__flex__texts">
                <div class="guide__tet__flex__texts__cat">
                    <?php
                        $mainCat = yoast_get_primary_term_id( 'guide_cat', get_the_ID() );
                        if($mainCat){
                            echo get_term($mainCat)->name;
                        }else{
                            echo get_the_term_list(get_the_ID(), 'guide_cat', '', ', ', '');
                        }
                    ?>
                </div>
                <h1><?php echo get_the_title(); ?></h1>
                <div class="guide__tet__flex__texts__excerpt">
                    <?php echo get_the_excerpt(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="guide__body">
        <a href="#" class="guide__body__back">Voir les autres articles</a>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="guide__body__content">
            <?php the_content(); ?>
        </div>
        <hr>
        <div class="guide__body__sharerate">
            <div class="guide__body__sharerate__share">
                <h3>Partager l'article</h3>
                <div class="guide__body__sharerate__share__links">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/social/facebook-round.svg" alt="Facebook">
                    </a>
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/social/linkedin-round.svg" alt="Facebook">
                    </a>
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/social/instagram-round.svg" alt="Facebook">
                    </a>
                    <a href="whatsapp://send?text=<?php echo get_the_permalink(); ?>" data-action="share/whatsapp/share">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/social/whatsapp-round.svg" alt="Facebook">
                    </a>
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/social/email-round.svg" alt="Facebook">
                    </a>
                </div>
            </div>
            <?php if(function_exists('the_ratings')) : ?>
            <div class="guide__body__sharerate__rate">
                <h3>Cet article vous a été utile ?</h3>
                <?php the_ratings(); ?>
            </div>
            <?php endif; ?>
        </div>
        <hr>
        <?php endwhile; endif; ?>
        <?php $faq = get_field('faq'); ?>
        <?php if(!is_null($faq) && !empty($faq) && is_array($faq)) : ?>
        <div class="guide__body__faq">
            <h2>Vos questions / <span>Nos réponses</span></h2>
            
        </div>
        <?php endif; ?>
        <?php $isShowEvent = get_field('global_event_show', 'option'); ?>
        <?php if($isShowEvent) : ?>
        <div class="guide__body__event">
            <img src="<?php echo get_field('global_event_img', 'option'); ?>" alt="<?php echo get_field('global_event_title', 'option'); ?>" class="guide__body__event__img">
            <div class="guide__body__event__texts">
                <h4><?php echo get_field('global_event_surtitle', 'option'); ?></h4>
                <h3><?php echo get_field('global_event_title', 'option'); ?></h3>
                <div class="guide__body__event__texts__date">
                    <?php
                        $dateDebutEvent = get_field('global_event_start', 'option');
                        $dateFinEvent = get_field('global_event_end', 'option');
                        $dateDebutEventArray = explode(' ', $dateDebutEvent);
                        $dateFinEventArray = explode(' ', $dateFinEvent);
                    ?>
                    du <?php echo $dateDebutEventArray[0]; echo ($dateDebutEventArray[1]!=$dateFinEventArray[1]) ? ' '.$dateDebutEventArray[1] : ''; echo ($dateDebutEventArray[2]!=$dateFinEventArray[2]) ? ' '.$dateDebutEventArray[2] : ''; ?> au <?php echo $dateFinEvent; ?>
                </div>
                <div class="guide__body__event__texts__text">
                    <?php echo get_field('global_event_text', 'option'); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="guide__more">
        <?php
            $morePosts = get_field('articles_associes');
            $nbPostsMore = 2;
            if(!is_null($morePosts) && !empty($morePosts) && is_array($morePosts)){
                $nbPostsMore = 2 - count($morePosts);
            }
            if($nbPostsMore<0){
                $nbPostsMore = 0;
            }
            $termsMorePosts = get_the_term_list(get_the_ID(), 'guide_cat', '', ',', '');
            $termsMorePostsArray = explode(',', $termsMorePosts);
            $argsMorePosts = array(
                'post_type' => 'guide',
                'posts_per_page' => $nbPostsMore,
                'ignore_sticky_posts' => false,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'guide_cat',
                        'field' => 'slug',
                        'terms' => $termsMorePostsArray,
                        'include_children' => false,
                        'operator' => 'AND'
                      )
                )
            );
            $queryMorePosts = new WP_Query($argsMorePosts);
        ?>
        <?php if((!is_null($morePosts) && !empty($morePosts) && is_array($morePosts)) || $queryMorePosts->have_posts()) : ?>
            <h2>Cela peut vous intéresser</h2>
        <?php endif; ?>
        <?php if(!is_null($morePosts) && !empty($morePosts) && is_array($morePosts)) : ?>
            <?php foreach($morePosts as $mp) : ?>
                <div class="guide__more__post" style="--bg-img: url('<?php echo str_replace("'", "\'", get_the_post_thumbnail_url($mp)); ?>');">
                    <div class="guide__more__post__cat">
                        <?php
                            $mainCat = yoast_get_primary_term_id( 'guide_cat', $mp );
                            if($mainCat){
                                echo get_term($mainCat)->name;
                            }else{
                                echo get_the_term_list($mp, 'guide_cat', '', ', ', '');
                            }
                        ?>
                    </div>
                    <div class="guide__more__post__title">
                        <?php echo get_the_title($mp); ?>
                    </div>
                    <a href="<?php echo get_the_permalink($mp); ?>" class="btn btn--arrow">Lire l'article</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if ( $queryMorePosts->have_posts() ) : while ( $queryMorePosts->have_posts() ) : $queryMorePosts->the_post(); ?>
            <div class="guide__more__post" style="--bg-img: url('<?php echo str_replace("'", "\'", get_the_post_thumbnail_url()); ?>');">
                <div class="guide__more__post__cat">
                    <?php
                        $mainCat = yoast_get_primary_term_id( 'guide_cat', get_the_ID() );
                        if($mainCat){
                            echo get_term($mainCat)->name;
                        }else{
                            echo get_the_term_list(get_the_ID(), 'guide_cat', '', ', ', '');
                        }
                    ?>
                </div>
                <div class="guide__more__post__title">
                    <?php echo get_the_title(); ?>
                </div>
                <a href="<?php echo get_the_permalink(); ?>" class="btn btn--arrow">Lire l'article</a>
            </div>
        <?php endwhile; endif; wp_reset_postdata(); ?>
    </div>

</main>

<?php get_footer(); ?>
