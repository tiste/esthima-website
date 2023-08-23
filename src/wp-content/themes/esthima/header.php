<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php wp_title(''); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
	<meta name="format-detection" content="telephone=no">
	<meta name="msapplication-TileColor" content="#D34C3B">
	<meta name="theme-color" content="#D43B68">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
	<header class="header <?php if (is_front_page()) : ?>header-transparent <?php endif;?>">
		<div class="header__top containerCustom">
			<a href="<?php echo home_url('/'); ?>" class="header__top__logo">
				<img src="<?php echo get_field('header_logo', 'option'); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" class="header__top__logo__img header__top__logo__img-normal">
				<img src="<?php echo get_field('header_logo_transparent', 'option'); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" class="header__top__logo__img header__top__logo__img-alt">
			</a>
			<div class="header__top__search">
				<?php get_search_form(); ?>
			</div>
			<div class="header__top__phone">
				<?php get_template_part('template-parts/phone-number'); ?>
			</div>
		</div>
		<div class="header__pink">
			<div class="header__pink__item header__pink__item-menu">
				<img src="<?php echo get_template_directory_uri(); ?>/images/menu.svg" alt="Menu" class="header__pink__item__picto">
				Menu
			</div>
			<?php $menuPink = get_field('header_menu', 'option'); ?>
			<?php foreach($menuPink as $m) : ?>
				<a href="<?php echo $m['link']['url']; ?>" target="<?php echo $m['link']['target']; ?>" class="header__pink__item">
					<img src="<?php echo $m['picto']; ?>" alt="<?php echo $m['link']['title']; ?>" class="header__pink__item__picto">
					<?php echo $m['link']['title']; ?>
				</a>
			<?php endforeach; ?>
		</div>
		<div class="header__menu">
			<img src="<?php echo get_template_directory_uri(); ?>/images/close.svg" alt="Fermer" class="header__menu__close">
			<?php wp_nav_menu(['menu'=>'Header - main', 'container_class'=>'header__menu__main']); ?>
			<?php wp_nav_menu(['menu'=>'Header - second', 'container_class'=>'header__menu__second']); ?>
			<?php
				$rs = get_field('global_social', 'option');
				if(!is_null($rs) && !empty($rs) && is_array($rs)) :
			?>
			<div class="header__menu__social">
				<?php foreach($rs as $s) : ?>
					<a href="<?php echo $s['link']; ?>" target="_blank" class="header__menu__social__link header__menu__social__link-<?php echo $s['reseau']; ?>"></a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
	</header>
