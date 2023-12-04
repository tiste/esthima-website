<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	get_header();
?>

<main class="main main-404 main-content">
    <div class="main-404__container">
        <div class="main-404__404">
            4<img src="<?php echo get_template_directory_uri(); ?>/images/chien-404.svg">4
        </div>
        <div class="main-404__text">
            La page que vous demandez n’existe pas.
        </div>
        <a href="<?php echo home_url('/'); ?>" class="btn btn--arrow">Retourner sur la page d'accueil</a>
    </div>
</main>

<?php get_footer(); ?>
