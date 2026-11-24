<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/*
* Template Name: Tracking
*/

get_header();

// Contexte hôte de l'espace client : uniquement ce que la SPA utilise, jamais
// le JWT ni une donnée personnelle. wp_logout_url() encode "&" en entité HTML.
$esthima_user = is_user_logged_in()
	? ['logoutUrl' => wp_specialchars_decode(wp_logout_url())]
	: null;
?>

<?php if ($esthima_user !== null) : ?>
<script>
    window.EsthimaUser = <?php echo wp_json_encode( $esthima_user ); ?>;
</script>
<?php endif; ?>

<?php
// Avec l'espace client, un <div> sans titre : la SPA porte le <main> et le seul <h1> de la page.
$is_spa_mounted = $esthima_user !== null && esthima_spa_is_enqueued();
$page_tag = $is_spa_mounted ? 'div' : 'main';
?>
<<?php echo $page_tag; ?> class="main main-content main-content--alt">
	<div class="wrap wrap--lg">
		<div class="tracking-box">
			<div class="yoast-breadcrumbs">
				<?php if (function_exists("yoast_breadcrumb")) {
					yoast_breadcrumb();
				} ?>
			</div>

			<?php if ($is_spa_mounted) : ?>
				<div id="esthima-espace-client"></div>
			<?php else : ?>
				<h1 class="page-header__title">Mon espace</h1>
				<?php if ($esthima_user === null) : ?>
					<p>
						<a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>">Connectez-vous pour accéder à votre espace</a>
					</p>
				<?php else : ?>
					<p role="alert">L’espace client ne peut pas être affiché pour le moment.</p>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</<?php echo $page_tag; ?>>

<?php get_footer(); ?>
