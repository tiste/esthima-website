<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="etapes">
<?php if( have_rows('etapes') ):
    while( have_rows('etapes') ) : the_row();
    $text = get_sub_field('text');
    $picto = get_sub_field('picto');
    $i = get_row_index();?>
    <div class="etapes-card"> 
        <div class="etapes-card__img">
            <div class="etapes-card__img__container">
                <img src="<?php echo $picto; ?>">
            </div>
        </div>
        <div class="etapes-card__text">
            <div class="etapes-card__text__step">
                Étape <?php echo $i; ?>
            </div>
            <div class="etapes-card__text__detail">
                <?php echo $text; ?>
            </div>
        </div>
    </div>
        <?php if ($i < 3) : ?>
            <img src="<?php echo get_template_directory_uri(); ?>/images/chevron-bigger.svg">
        <?php endif;?>
    <?php endwhile;
endif;?>
</div>