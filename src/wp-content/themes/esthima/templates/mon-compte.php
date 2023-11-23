<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 

/*
* Template Name: Mon compte
*/
get_header();
?>

<main class="main main-content main-content--alt">

	<div class="wrap wrap--lg">

        <div class="main-bg">

            <div class="page-header">
                <div class="page-header__title">
                    Mon compte
                </div>
                <div class="page-header__intro">
                    <?php $current_user = wp_get_current_user(); ?>
                    Bonjour<?php echo !empty($current_user->user_firstname) ? ' '.$current_user->user_firstname : ''; ?>,
                </div>
                <div class="page-header__text">
                    À partir du tableau de bord de votre compte, vous pouvez visualiser vos commandes récentes, gérer vos adresses de livraison et de facturation ainsi que changer votre mot de passe et les détails de votre compte.
                </div>
            </div>
            
        
            <?php if ( have_posts() ) : ?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <div class="the-content">
                        <?php the_content() ?>
                    </div>
                    
                <?php endwhile; ?>

            <?php endif; ?>

        </div>
		
	</div>

</main


<?php get_footer(); ?>