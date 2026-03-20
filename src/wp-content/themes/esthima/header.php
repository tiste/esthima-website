<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Google Tag Manager -->
	<script>
	var dataLayer = dataLayer || [];
	(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://tagging.esthima.fr/ypc478dgsgsn55k.js?awl='+i.replace(/^GTM-/, '')+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-KKDFVPD');
	</script>
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

<body <?php body_class(); ?>>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src=https://tagging.esthima.fr/ns.html?id=GTM-KKDFVPD height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

    <?php if ( ! defined( 'ABSPATH' ) ) exit;
    get_header();

    $sso_logged_in = is_user_logged_in();
    $sso_user      = wp_get_current_user();
    $sso_cookie    = isset( $_COOKIE['jwt_token'] );
    $sso_managed   = $sso_logged_in && get_user_meta( $sso_user->ID, '_sso_jwt_managed', true );
    $sso_functional = $sso_logged_in ? (string) get_user_meta( $sso_user->ID, '_sso_functional_id', true ) : '';
    ?>
    <main style="min-height:100vh;display:flex;align-items:center;justify-content:center;background:#0f172a;font-family:monospace">
        <div style="background:#1e293b;color:#e2e8f0;padding:32px 40px;border-radius:12px;box-shadow:0 8px 32px rgba(0,0,0,.5);min-width:320px">
            <div style="font-size:11px;text-transform:uppercase;letter-spacing:.1em;color:#64748b;margin-bottom:16px">SSO Debug</div>

            <?php if ( $sso_logged_in ) : ?>
                <div style="color:#4ade80;font-size:18px;font-weight:bold;margin-bottom:16px">✓ Connecté</div>
                <table style="border-collapse:collapse;width:100%;font-size:14px">
                    <tr><td style="color:#64748b;padding:4px 16px 4px 0">ID</td><td><?php echo esc_html( $sso_user->ID ); ?></td></tr>
                    <tr><td style="color:#64748b;padding:4px 16px 4px 0">Login</td><td><?php echo esc_html( $sso_user->user_login ); ?></td></tr>
                    <tr><td style="color:#64748b;padding:4px 16px 4px 0">Email</td><td><?php echo esc_html( $sso_user->user_email ); ?></td></tr>
                    <tr><td style="color:#64748b;padding:4px 16px 4px 0">Prénom</td><td><?php echo esc_html( $sso_user->first_name ); ?></td></tr>
                    <tr><td style="color:#64748b;padding:4px 16px 4px 0">Nom</td><td><?php echo esc_html( $sso_user->last_name ); ?></td></tr>
                    <tr><td style="color:#64748b;padding:4px 16px 4px 0">Rôle</td><td><?php echo esc_html( implode( ', ', $sso_user->roles ) ); ?></td></tr>
                    <tr><td style="color:#64748b;padding:4px 16px 4px 0">functionalId</td><td><?php echo $sso_functional ? esc_html( $sso_functional ) : '<span style="color:#94a3b8">—</span>'; ?></td></tr>
                    <tr>
                        <td style="color:#64748b;padding:4px 16px 4px 0">Compte SSO</td>
                        <td><?php echo $sso_managed ? '<span style="color:#4ade80">oui</span>' : '<span style="color:#94a3b8">non (natif)</span>'; ?></td>
                    </tr>
                </table>
            <?php else : ?>
                <div style="color:#f87171;font-size:18px;font-weight:bold;margin-bottom:16px">✗ Non connecté</div>
            <?php endif; ?>

            <div style="margin-top:20px;padding-top:16px;border-top:1px solid #334155;font-size:13px">
                <span style="color:#64748b">Cookie <code>jwt_token</code> :</span>
                <?php if ( $sso_cookie ) : ?>
                    <span style="color:#4ade80">présent</span>
                <?php else : ?>
                    <span style="color:#f87171">absent</span>
                <?php endif; ?>
            </div>
        </div>
    </main>

	<header class="header <?php if (is_front_page()) : ?>header-transparent header-transparent-active <?php endif;?>">
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
			<div class="header__menu__search">
				<?php get_search_form(); ?>
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

	<?php if (!is_front_page()) : ?>
	<div class="heightHeader"></div>
	<?php endif; ?>
