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

	<?php global $template; ?>
	<?php if(basename($template)=='presse.php' || basename($template)=='guides-conseils.php' || basename($template)=='taxonomy-guide_cat.php' || basename($template)=='taxonomy-product-cat.php' || basename($template)=='archive-product.php') : ?>
		<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
		<title><?php echo str_replace(array(' | Esthima', ' - Esthima'), '', wp_title('', false)); echo ($paged>1) ? ' Page '.$paged: ''; echo ' | Esthima'; ?></title>
	<?php else : ?>
		<title><?php wp_title(''); ?></title>
	<?php endif; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
	<meta name="format-detection" content="telephone=no">
	<meta name="msapplication-TileColor" content="#D34C3B">
	<meta name="theme-color" content="#D43B68">
	<?php wp_head(); ?>
</head>

<body <?php body_class("page-landing"); ?>>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KKDFVPD"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->							
									
			<?php $attachment_image = wp_get_attachment_url( 3362 ); ?>					
									
	<header class="header header__landing">
		<div class="header__top containerCustom">
			<a href="<?php echo home_url('/'); ?>" class="header__top__logo">
				<img src="https://media.cie-veterinaires.fr/images/logos/logo_esthima.png" alt="<?php echo get_bloginfo( 'name' ); ?>" class="header__top__logo__img header__top__logo__img-normal">
			</a>
		</div>
	</header>
	<div class="heightHeader"></div>