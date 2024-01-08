<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php $steps = get_field('etapes'); ?>
<?php if( have_rows('etapes') ) : ?>
<div class="hp__conf__steps">
    <?php while( have_rows('etapes') ) : the_row(); ?>
        <?php
            $text = get_sub_field('text');
            $picto = get_sub_field('picto');
            $i = get_row_index();
        ?>
        <div class="hp__conf__steps__item">
            <div class="hp__conf__steps__item__img">
                <img src="<?php echo $picto; ?>" alt="Étape <?php echo $i; ?> - <?php echo $text; ?>">
            </div>
            <div class="hp__conf__steps__item__text">
                <div class="hp__conf__steps__item__text__title">Étape <?php echo $i; ?></div>
                <div class="hp__conf__steps__item__text__text"><?php echo $text; ?></div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<?php endif; ?>