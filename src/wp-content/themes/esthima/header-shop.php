<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Google Tag Manager -->
	<script>
	var dataLayer = dataLayer || [];
	(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-KKDFVPD');</script>
	<!-- End Google Tag Manager -->		

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<?php /* SWIPER - CSS (here because autoptimize is loaded before the title tag) */ ?>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>

	<title><?php wp_title(''); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
	<meta name="format-detection" content="telephone=no">
	<meta name="msapplication-TileColor" content="#D34C3B">
	<meta name="theme-color" content="#D43B68">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KKDFVPD"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	
	<header class="header <?php if (is_front_page()) : ?>header-transparent header-transparent-active <?php endif;?>">
		<div class="header__top header__top-shop containerCustom">
			<a href="<?php echo home_url('/'); ?>" class="header__top__logo">
				<img src="<?php echo get_field('header_logo', 'option'); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" class="header__top__logo__img header__top__logo__img-normal">
				<img src="<?php echo get_field('header_logo_transparent', 'option'); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" class="header__top__logo__img header__top__logo__img-alt">
			</a>
			<div class="header__top__search-shop">
				<?php get_search_form(); ?>
			</div>
			<div class="header__top__shop-parts">
				<div class="header__top__shop-parts__account">
					<img src="<?php echo get_template_directory_uri(); ?>/images/my-account.svg" class="header__top__shop-parts__account__picto">
					<div class="header__top__shop-parts__account__text">
						Mon compte
						<?php if(!is_user_logged_in()) : ?>
							<span>Connexion</span>
						<?php endif; ?>
					</div>
					<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"></a>
				</div>
				<div class="header__top__shop-parts__cart">
					<?php if(WC()->cart->get_cart_contents_count() > 0) : ?>
						<div class="header__top__shop-parts__cart__number">
							<?php echo WC()->cart->get_cart_contents_count(); ?>
						</div>
					<?php endif; ?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/cart.svg" class="header__top__shop-parts__cart__picto">
					<div class="header__top__shop-parts__cart__text">
						Mon panier
						<span><?php global $woocommerce; echo $woocommerce->cart->get_cart_total(); ?></span>
					</div>
					<a href="<?php echo wc_get_cart_url(); ?>"></a>
				</div>
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
			<div class="header__menu__search">
				<?php get_search_form(); ?>
			</div>
			<div class="header__menu__shop">
				<?php wp_list_categories( array('taxonomy' => 'product_cat', 'title_li'  => '') ); ?>
			</div>
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

	<div class="heightHeader"></div>

	<div class="main-content">
		<div class="shop__cats">
			<?php wp_list_categories( array('taxonomy' => 'product_cat', 'title_li'  => '') ); ?>
		</div>
	</div>
