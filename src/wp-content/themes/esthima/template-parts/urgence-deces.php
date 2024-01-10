<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div class="urgence-deces">
    <div class="urgence-deces__titles">
        <h2>Urgence décès ?</h2>
        <span class="urgence-deces__titles__subtitle">Contactez-nous</span>
    </div>
    <div class="urgence-deces__blocks">
        <div class="urgence-deces__blocks__item">
            <img src="<?php echo get_template_directory_uri(); ?>/images/phone.svg" alt="Téléphone" class="urgence-deces__blocks__item__picto">
            <span class="urgence-deces__blocks__item__title">Par téléphone</span>
            <?php echo get_template_part('template-parts/phone-number'); ?>
            <a href="<?php echo home_url('/'); ?>urgence-deces/" class="urgence-deces__blocks__item__link btn btn--arrow">
                Me rappeler
            </a>
        </div>
        <div class="urgence-deces__blocks__item">
            <img src="<?php echo get_template_directory_uri(); ?>/images/email.svg" alt="Email" class="urgence-deces__blocks__item__picto">
            <span class="urgence-deces__blocks__item__title">Par email</span>
            <div class="urgence-deces__blocks__item__text">
                En utilisant notre formulaire de contact
            </div>
            <a href="<?php echo get_permalink(get_field('global_contact', 'option')[0]); ?>" class="urgence-deces__blocks__item__link btn btn--arrow">
                Formulaire de contact
            </a>
        </div>
    </div>
</div>
