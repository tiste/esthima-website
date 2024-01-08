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
                <?php if(is_user_logged_in()) : ?>
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
                <?php else : ?>
                <div class="page-header__title">
                    Mon espace
                </div>
                <?php endif; ?>
            </div>
            
        
            <?php if ( have_posts() && is_user_logged_in() ) : ?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <div class="the-content">
                        <?php the_content() ?>
                    </div>
                    
                <?php endwhile; ?>

            <?php else : ?>
                <div class="inscription">
                    <div class="inscription__login">
                        <h2>Connexion</h2>
                        <?php echo do_shortcode('[gravityform action="login" title="false" description="false" logged_in_avatar="false" logged_in_message="Vous êtes bien connecté" login_redirect="'.home_url('/').'mon-compte/" logout_redirect="'.home_url('/').'" registration_link_display="false" forgot_password_display="false" /]'); ?>
                    </div>
                    <div class="inscription__register">
                        <h2>Inscription</h2>
                        <?php echo do_shortcode('[gravityform id="4" title="false" description="false" ajax="true"]'); ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
		
	</div>

</main


<?php get_footer(); ?>