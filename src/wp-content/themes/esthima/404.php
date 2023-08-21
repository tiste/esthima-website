<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	get_header();
?>

<main class="main main-404">
  <div>
    <img src="<?php echo get_template_directory_uri();?>/images/sceco_404.svg">
  </div>
	<h1 class="main-404__title">Nous ne trouvons aucun&nbsp;résultat ...</h1>
  <div class="main-404__text">
    Désolé, nous ne parvenons pas à trouver ce&nbsp;que&nbsp;vous&nbsp;cherchez.
  </div>
  <a href="<?php echo home_url('/'); ?>" class="btn">Retourner à la page d'accueil</a>
</main>

<?php get_footer(); ?>
