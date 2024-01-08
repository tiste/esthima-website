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
        <a href="<?php echo home_url('/'); ?>conseils-actualites/" class="guide__body__back">Voir les autres articles</a>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="guide__body__content">
            <?php the_content(); ?>
        </div>
        <hr>
        <div class="guide__body__sharerate">
            <div class="guide__body__sharerate__share">
            <div class="guide__body__sharerate__share__title">Partager l'article</div>
                <div class="guide__body__sharerate__share__links">
                    <a href="https://facebook.com/sharer.php?u=<?php echo home_url('').$_SERVER['REQUEST_URI']; ?>" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/social/facebook-round.svg" alt="Facebook">
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?url=<?php echo home_url('').$_SERVER['REQUEST_URI']; ?>&title=<?php echo str_replace(' ', '%20', get_the_title()); ?>&summary=<?php echo str_replace(' ', '%20', get_the_title()); ?>&source=<?php echo $_SERVER['HTTP_HOST']; ?>" target="_blank">
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
            <div class="guide__body__sharerate__rate">
                <?php echo do_shortcode('[was_this_article_helpful]'); ?>
            </div>
        </div>
        <hr>
        <?php endwhile; endif; ?>
        <?php $faq = get_field('faq'); ?>
        <?php if(!is_null($faq) && !empty($faq) && is_array($faq)) : ?>
        <div class="guide__body__faq">
            <h2>Vos questions / <span>Nos réponses</span></h2>
            <ul class="list-faq">
                <?php $currentFAQ = 0; foreach($faq as $f) : ?>
                    <li class="list-faq__item <?php echo ($currentFAQ==0) ? 'list-faq__item-open' : 'list-faq__item-closed'; ?>">
                        <div class="list-faq__item__question">
                            <?php echo get_the_title($f); ?>
                        </div>
                        <div class="list-faq__item__answer">
                            <div class="list-faq__item__answer__content">
                                <?php
                                    $myFAQ = get_post($f);
                                    echo apply_filters('the_content',$myFAQ->post_content);
                                ?>
                            </div>
                        </div>
                    </li>
                <?php $currentFAQ++; endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php $isShowEvent = get_field('global_event_show', 'option'); ?>
        <?php if($isShowEvent) : ?>
        <div class="guide__body__event">
            <div class="guide__body__event__flex">
                <img src="<?php echo get_field('global_event_img', 'option'); ?>" alt="<?php echo get_field('global_event_title', 'option'); ?>" class="guide__body__event__img">
                <div class="guide__body__event__texts">
                    <div class="guide__body__event__texts__surtitle"><?php echo get_field('global_event_surtitle', 'option'); ?></div>
                    <div class="guide__body__event__texts__title"><?php echo get_field('global_event_title', 'option'); ?></div>
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
        </div>
        <?php endif; ?>
    </div>

    <?php
        $morePosts = get_field('articles_associes');
        $nbPostsMore = 2;
        if(!is_null($morePosts) && !empty($morePosts) && is_array($morePosts)){
            $nbPostsMore = 2 - count($morePosts);
        }
        if($nbPostsMore<0){
            $nbPostsMore = 0;
        }
        $termsMorePosts = get_the_terms( get_the_ID(), 'guide_cat' );
        $termsMorePostsArray = array();
        if(!is_null($termsMorePosts) && !empty($termsMorePosts) && is_array($termsMorePosts)){
            foreach($termsMorePosts as $t){
                $termsMorePostsArray[] = $t->slug;
            }
        }
        $postsNotIn = array(get_the_ID());
        if(!is_null($morePosts) && !empty($morePosts) && is_array($morePosts)){
            foreach($morePosts as $mp){
                $postsNotIn[] = $mp;
            }
        }
        if($nbPostsMore>0){
            $argsMorePosts = array(
                'post_type' => 'guide',
                'posts_per_page' => $nbPostsMore,
                'ignore_sticky_posts' => true,
                'post__not_in' => $postsNotIn,
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
        }
    ?>
    <?php if((!is_null($morePosts) && !empty($morePosts) && is_array($morePosts)) || $queryMorePosts->have_posts()) : ?>
    <div class="guide__more">
        <div class="guide__more__title">Cela peut vous intéresser</div>
        <div class="guide__more__flex">
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
        <?php if($nbPostsMore>0) : if ( $queryMorePosts->have_posts() ) : while ( $queryMorePosts->have_posts() ) : $queryMorePosts->the_post(); ?>
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
        <?php endwhile; endif; wp_reset_postdata(); endif; ?>
        </div>
    </div>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
