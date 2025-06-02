<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
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
		<div class="header__top containerCustom">
			<a href="<?php echo home_url('/'); ?>" class="header__top__logo">
				<img src="<?php echo get_field('header_logo', 'option'); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" class="header__top__logo__img header__top__logo__img-normal">
				<img src="<?php echo get_field('header_logo_transparent', 'option'); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" class="header__top__logo__img header__top__logo__img-alt">
			</a>
			<div class="header__top__phone">
				<?php get_template_part('template-parts/phone-number'); ?>
			</div>
		</div>
	
	</header>

	<?php if (!is_front_page()) : ?>
	<div class="heightHeader"></div>
	<?php endif; ?>
