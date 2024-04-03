<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	get_header();
?>

<main class="main">

	<div class="hp__tet" style="--bg-img: url('<?php echo str_replace("'", "\'", get_field('tet_background')) ?>')">
		<?php if(!is_null(get_field('tet_bgvid')) && !empty(get_field('tet_bgvid'))) : ?>
		<div class="hp__tet__video">
			<video autoplay muted loop>
				<source src="<?php echo get_field('tet_bgvid'); ?>" />
			</video>
		</div>
		<?php endif; ?>
		<div class="hp__tet__container">
			<div class="hp__tet__reviews"></div>
			<h1><?php echo get_field('tet_title'); ?></h1>
			<div class="hp__tet__text">
				<?php echo get_field('tet_text'); ?>
			</div>
			<?php
				$tetBtns = get_field('tet_btns');
				if(!is_null($tetBtns) && !empty($tetBtns) && is_array($tetBtns)) :
			?>
			<div class="hp__tet__btns">
				<?php foreach($tetBtns as $btn) : ?>
					<a href="<?php echo $btn['link']['url']; ?>" target="<?php echo $btn['link']['target']; ?>" class="btn btn--arrow"><?php echo $btn['link']['title']; ?></a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="hp__services">
		<div class="lightBG">
			<div class="containerCustom2">
				<?php
					$services = get_field('services_services');
					if(!is_null($services) && !empty($services) && is_array($services)) :
				?>
				<div class="hp__services__serv">
					<?php foreach($services as $s) : ?>
						<div class="hp__services__serv__item">
							<div class="hp__services__serv__item__picto">
								<img src="<?php echo $s['picto']; ?>" alt="<?php echo $s['text']; ?>">
							</div>
							<div class="hp__services__serv__item__text">
								<?php echo $s['text']; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
				<h2><?php echo get_field('services_title'); ?></h2>
			</div>
		</div>
		<?php
			$servicesVignettes = get_field('services_vignettes');
			if(!is_null($servicesVignettes) && !empty($servicesVignettes) && is_array($servicesVignettes)) :
		?>
		<div class="containerCustom2">
			<div class="hp__services__vignettes">
				<?php foreach($servicesVignettes as $sv) : ?>
					<div class="hp__services__vignettes__item" style="--bg-img: url('<?php echo str_replace("'", "\'", $sv['image']); ?>')">
						<h3 class="hp__services__vignettes__item__text">
							Pour <span><?php echo $sv['link']['title']; ?></span>
						</h3>
						<img src="<?php echo get_template_directory_uri(); ?>/images/arrow-big.svg" class="hp__services__vignettes__item__arrow">
						<a href="<?php echo $sv['link']['url']; ?>" target="<?php echo $sv['link']['target']; ?>"></a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
	</div>

	<div class="hp__conf">
		<a href="/parcours-de-confiance" class="containerCustom2">
			<div class="hp__conf__top">
				<h2><?php echo get_field('conf_title'); ?></h2>
				<div class="hp__conf__top__text">
					<?php echo get_field('conf_text'); ?>
				</div>
			</div>
			<?php
				$confSteps = get_field('conf_parcours');
				if(!is_null($confSteps) && !empty($confSteps) && is_array($confSteps)) :
			?>
			<div class="hp__conf__steps">
				<?php foreach($confSteps as $key => $cs) : ?>
					<div class="hp__conf__steps__item">
						<div class="hp__conf__steps__item__img">
							<img src="<?php echo $cs['picto'] ?>" alt="Étape <?php echo $key+1; ?> - <?php echo $cs['text'] ?>">
						</div>
						<div class="hp__conf__steps__item__text">
							<div class="hp__conf__steps__item__text__title">Étape <?php echo $key+1; ?></div>
							<div class="hp__conf__steps__item__text__text"><?php echo $cs['text'] ?></div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</a>
	</div>

	<div class="hp__urgence">
		<div class="containerCustom2">
			<?php get_template_part('template-parts/urgence-deces'); ?>
		</div>
	</div>

	<div class="hp__imgblock" style="--bg-img: url('<?php echo str_replace("'", "\'", get_field('imgblock_img')); ?>')">
		<img src="<?php echo str_replace('"', '\"', get_field('imgblock_img')); ?>" alt="<?php echo str_replace('"', '\"', get_field('imgblock_title')); ?>" class="hp__imgblock__prezimg">
		<div class="hp__imgblock__block">
			<h2><?php echo get_field('imgblock_title'); ?></h2>
			<div class="hp__imgblock__block__text">
				<?php echo get_field('imgblock_text'); ?>
			</div>
			<?php
				$imgBtns = get_field('imgblock_btns');
				if(!is_null($imgBtns) && !empty($imgBtns) && is_array($imgBtns)) :
			?>
			<div class="hp__imgblock__block__btns">
				<?php foreach($imgBtns as $btn) : ?>
					<a href="<?php echo $btn['link']['url']; ?>" target="<?php echo $btn['link']['target']; ?>" class="btn btn--arrow btn--arrow--white"><?php echo $btn['link']['title']; ?></a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			<a href="/espace-presse" class="hp__imgblock__block__subtitle"><?php echo get_field('imgblock_subtitle'); ?></a>
			<?php
				$refs = get_field('imgblock_refs');
				if(!is_null($refs) && !empty($refs) && is_array($refs)) :
			?>
			<a href="/espace-presse" class="hp__imgblock__block__refs">
				<?php foreach($refs as $ref) : ?>
					<img src="<?php echo $ref['logo']; ?>" alt="<?php echo $ref['name']; ?>">
				<?php endforeach; ?>
			</a>
			<?php endif; ?>
		</div>
	</div>

	<div class="hp__shop">
		<div class="containerCustom2">
			<h3><?php echo get_field('shop_surtitle'); ?></h3>
			<h2><?php echo get_field('shop_title'); ?></h2>
			<div class="hp__shop__text">
				<?php echo get_field('shop_text'); ?>
			</div>
			<?php
				// $cats = get_field('shop_products');
				$argsShop = array(
					'post_type' => 'product',
					'meta_key' => 'total_sales',
					'orderby' => 'meta_value_num',
					'posts_per_page' => 4,
				);
				$queryShop = new WP_Query( $argsShop );
				if ( $queryShop->have_posts() ) :
			?>
			<div class="hp__shop__cats">
				<?php while ( $queryShop->have_posts() ) : $queryShop->the_post(); global $product; ?>
					<div class="hp__shop__cats__item">
						<div class="hp__shop__cats__item__img">
							<img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(), 'single-post-thumbnail')[0]; ?>" alt="<?php echo $product->get_name(); ?>">
						</div>
						<div class="hp__shop__cats__item__cat">
							<?php echo get_the_terms(get_the_ID(), 'product_cat')[0]->name; ?>
						</div>
						<h3 class="hp__shop__cats__item__name">
							<?php echo $product->get_name(); ?>
						</h3>
						<div class="hp__shop__cats__item__minprice">
							à partir de <?php echo $product->get_price(); ?>€
						</div>
						<a href="<?php echo $product->get_permalink(); ?>"></a>
					</div>
				<?php endwhile; ?>
			</div>
			<?php endif; wp_reset_postdata(); ?>
			<?php
				$btnShop = get_field('shop_link');
				if(!is_null($btnShop) && !empty($btnShop) && is_array($btnShop)) :
			?>
			<a href="<?php echo $btnShop['url']; ?>" target="<?php echo $btnShop['target']; ?>" class="hp__shop__btn btn btn--arrow"><?php echo $btnShop['title']; ?></a>
			<?php endif; ?>
		</div>
	</div>
		
	<?php
		$guides = get_field('tips_blocks');
		if(!is_null($guides) && !empty($guides) && is_array($guides)) :
	?>
	<div class="hp__guides">
		<div class="containerCustom2">
			<h2><?php echo get_field('tips_title'); ?></h2>
		</div>
		<?php foreach($guides as $key => $g) : ?>
			<div class="hp__guides__item hp__guides__item-<?php echo $key+1; ?>">
				<div class="hp__guides__item__img">
					<?php if(!is_null($g['guide']) && !empty($g['guide'])) : ?>
					<a href="<?php echo str_replace('"', '\"', get_permalink($g['guide'][0])); ?>">
					<?php endif; ?>
						<img src="<?php echo $g['image']; ?>" alt="<?php echo $g['title']; ?>">
					<?php if(!is_null($g['guide']) && !empty($g['guide'])) : ?>
					</a>
					<?php endif; ?>
					</div>
				<?php if($key==0) : ?>
				<div class="containerCustom2">
					<div class="hp__guides__item__texts">
						<?php if(!is_null($g['guide']) && !empty($g['guide'])) : ?>
						<a href="<?php echo str_replace('"', '\"', get_permalink($g['guide'][0])); ?>">
						<?php endif; ?>
							<h3 class="hp__guides__item__title">
								<?php echo $g['title']; ?>
							</h3>
						<?php if(!is_null($g['guide']) && !empty($g['guide'])) : ?>
						</a>
						<?php endif; ?>
						<div class="hp__guides__item__text">
							<?php echo $g['text']; ?>
						</div>
					</div>
				</div>
				<?php else : ?>
					<div class="hp__guides__item__texts">
						<?php if(!is_null($g['guide']) && !empty($g['guide'])) : ?>
						<a href="<?php echo str_replace('"', '\"', get_permalink($g['guide'][0])); ?>">
						<?php endif; ?>
							<h3 class="hp__guides__item__title">
								<?php echo $g['title']; ?>
							</h3>
						<?php if(!is_null($g['guide']) && !empty($g['guide'])) : ?>
						</a>
						<?php endif; ?>
						<div class="hp__guides__item__text">
							<?php echo $g['text']; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		<a href="<?php echo home_url('/'); ?>conseils-actualites" class="btn btn--arrow">Tous nos guides & conseils</a>
	</div>
	<?php endif; ?>

	<div class="containerCustom2">
		<div class="hp__reviews">
			<div class="skeepers_carousel_container" data-slides-count="4"></div><script async charset="utf-8" src="//widgets.rr.skeepers.io/carousel/234e7099-e96e-9c14-3963-2f6cb14903c5/a689b41b-194f-4f19-b764-d84f8a5d4898.js"></script>
		</div>
		<div class="hp__content">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content() ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>


</main>

<?php get_footer(); ?>
