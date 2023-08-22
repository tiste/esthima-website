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
		<div class="header__top">
			<a href="<?php echo home_url('/'); ?>">
				<img src="<?php //echo get_field(''); ?>" alt="">
			</a>
		</div>
		<div class="header__pink">

		</div>
	</header>
