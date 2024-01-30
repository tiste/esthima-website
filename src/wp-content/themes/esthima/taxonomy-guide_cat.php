<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 
?>
<?php get_header(); 
?>

<main class="main main-content">

<?php
$parent = get_queried_object()->parent;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$argsSticky = array(
    'post_type' => 'guide',
    'posts_per_page' => 1,
    'meta_key' => 'sticky',
    'meta_value' => '1',
    'compare' => '!=',
	'tax_query' => array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'guide_cat',
			'field' => 'term_id',
			'terms' => get_queried_object()->term_id,
			'include_children' => false,
			'operator' => 'AND'
			)
	)
);
$querySticky = get_posts($argsSticky);
if(empty($querySticky)){
    $argsSticky = array(
        'post_type' => 'guide',
        'posts_per_page' => 1,
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'guide_cat',
				'field' => 'term_id',
				'terms' => get_queried_object()->term_id,
				'include_children' => false,
				'operator' => 'AND'
				)
		)
    );
    $querySticky = get_posts($argsSticky);
}
$argsRegular = array(
    'post_type' => 'guide',
    'posts_per_page' => 8,
    'post__not_in' => array($querySticky[0]->ID),
    'paged' => $paged,
	'tax_query' => array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'guide_cat',
			'field' => 'term_id',
			'terms' => get_queried_object()->term_id,
			'include_children' => false,
			'operator' => 'AND'
			)
	)
);
$queryRegular = new WP_Query($argsRegular);
?>

    <div class="guides__tet">
        <div class="lightBG"></div>
        <div class="guides__tet__breadcrumbs">
            <span>
                <span><a href="<?php echo home_url(); ?>">Accueil</a></span> &gt;
                <span><a href="<?php echo home_url('/'); ?>conseils-actualites">Nos guides &amp; nos conseils</a></span> &gt;
                <?php if($parent!=0) : ?>
                    <span><a href="<?php echo get_term_link($parent); ?>"><?php echo get_term($parent)->name; ?></a></span> &gt;
                <?php endif; ?>
                <span class="breadcrumb_last" aria-current="page"><?php echo get_queried_object()->name; ?></span>
            </span>
        </div>
        <div class="guides__tet__texts">
            <h1>
                <?php if($parent!=0) : ?>
                    <span><?php echo get_term($parent)->name; ?></span>
                <?php endif; ?>
                <?php echo get_queried_object()->name; ?>
            </h1>
            <h2><?php echo get_field('tet_subtitle'); ?></h2>
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
		$cats = get_terms( array(
			'taxonomy' => 'guide_cat',
			'hide_empty' => false,
			'hierarchical' => true,
			'parent' => 0
		) );
		if($parent==0){
			$catsChild = get_terms( array(
				'taxonomy' => 'guide_cat',
				'hide_empty' => false,
				'hierarchical' => true,
				'parent' => get_queried_object()->term_id
			) );
		}else{
			$catsChild = get_terms( array(
				'taxonomy' => 'guide_cat',
				'hide_empty' => false,
				'hierarchical' => true,
				'parent' => $parent
			) );
		}
	?>
    <div class="guides__cats guides__cats-parent">
        <a href="<?php echo home_url('/'); ?>conseils-actualites">Tous les articles</a>
        <?php if(!is_null($cats) && !empty($cats) && is_array($cats)) : ?>
            <?php foreach($cats as $c) : ?>
                <a href="<?php echo get_term_link($c); ?>" <?php echo ($c->term_id==get_queried_object()->term_id || $c->term_id==$parent) ? 'class="active"' : ''; ?>><?php echo $c->name; ?></a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
	<div class="guides__cats guides__cats-child">
        <?php if(!is_null($catsChild) && !empty($catsChild) && is_array($catsChild)) : ?>
            <?php foreach($catsChild as $c) : ?>
                <a href="<?php echo get_term_link($c); ?>" <?php echo ($c->term_id==get_queried_object()->term_id) ? 'class="active"' : ''; ?>><?php echo $c->name; ?></a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php $currentURL = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>

    <select class="guides__cats-mob">
        <option value="<?php echo str_replace('"', '\"', home_url('/')); ?>conseils-actualites/">Tous les articles</option>
        <?php if(!is_null($cats) && !empty($cats) && is_array($cats)) : ?>
            <?php foreach($cats as $c) : ?>
                <option value="<?php echo str_replace('"', '\"', get_term_link($c)); ?>" <?php echo ($currentURL==get_term_link($c)) ? 'selected' : ''; ?>><?php echo $c->name; ?></option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>

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

    <div class="shop__seo">
        <h2><?php echo get_field('seo_title'); ?></h2>
        <div class="shop__seo__text">
            <?php echo get_field('seo_text'); ?>
        </div>
    </div>

</main>


<?php get_footer(); ?>