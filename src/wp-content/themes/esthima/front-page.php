<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	get_header();
?>

<main class="main">
	
	<?php //if ( have_posts() ) : ?>
		<?php //while ( have_posts() ) : the_post(); ?>
			<?php //the_content() ?>
		<?php //endwhile; ?>
	<?php //endif; ?>

	<div class="hp__tet" style="--bg-img: url('<?php echo str_replace("'", "\'", get_field('tet_background')) ?>')">
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
				<a href="<?php echo $btn['link']['url']; ?>" target="<?php echo $btn['link']['target']; ?>"><?php echo $btn['link']['title']; ?></a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>

	<div class="hp__services">
		<div class="lightBG">
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
		<?php
			$servicesVignettes = get_field('services_vignettes');
			if(!is_null($servicesVignettes) && !empty($servicesVignettes) && is_array($servicesVignettes)) :
		?>
		<div class="hp__services__vignettes">
			<?php foreach($servicesVignettes as $sv) : ?>
				<div class="hp__services__vignettes__item" style="--bg-img: url('<?php echo str_replace("'", "\'", $sv['image']); ?>')">
					<div class="hp__services__vignettes__item__text">
						Pour <span><?php echo $sv['link']['title']; ?></span>
					</div>
					<a href="<?php echo $sv['link']['url']; ?>" target="<?php echo $sv['link']['target']; ?>"></a>
				</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>

	<div class="hp__conf">
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
	</div>

	<div class="hp__urgence">
		<?php get_template_part('template-parts/urgence-deces'); ?>
	</div>

	<div class="hp__imgblock" style="--bg-img: url('<?php echo str_replace("'", "\'", get_field('imgblock_img')); ?>')">
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
					<a href="<?php echo $btn['link']['url']; ?>" target="<?php echo $btn['link']['target']; ?>"><?php echo $btn['link']['title']; ?></a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			<h3><?php echo get_field('imgblock_subtitle'); ?></h3>
			<?php
				$refs = get_field('imgblock_refs');
				if(!is_null($refs) && !empty($refs) && is_array($refs)) :
			?>
			<div class="hp__imgblock__block__refs">
				<?php foreach($refs as $ref) : ?>
					<img src="<?php echo $ref['logo']; ?>" alt="<?php echo $ref['name']; ?>">
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
		
	<div class="skeepers_carousel_container" data-slides-count="4"></div><script async charset="utf-8" src="//widgets.rr.skeepers.io/carousel/234e7099-e96e-9c14-3963-2f6cb14903c5/a689b41b-194f-4f19-b764-d84f8a5d4898.js"></script>
</main>

<?php get_footer(); ?>
