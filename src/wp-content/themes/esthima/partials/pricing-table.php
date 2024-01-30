<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php $cremations = get_field('cremations'); ?>

<?php if(!is_null($cremations) && !empty($cremations) && is_array($cremations)) : ?>
<div class="pricing-table">
    <?php foreach($cremations as $c) : ?>
        <div class="pricing-plan">
            <h2 class="pricing-plan__head">
                <span class="pricing-plan__head__icon"></span>
                <span class="pricing-plan__head__surtitle">La crémation</span>
                <span class="pricing-plan__head__title"><?php echo $c['name']; ?></span>
                <span class="pricing-plan__head__more">En savoir plus</span>
            </h2>
            <div class="pricing-plan__prices">
                <div class="pricing-plan__prices__card">
                    <div class="pricing-plan__prices__card__price">
                        <?php echo $c['tarif1']; ?>€
                    </div>
                    <div class="pricing-plan__prices__card__animal">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/nac.svg" alt="NAC">
                        NAC
                    </div>
                </div>
                <div class="pricing-plan__prices__card">
                    <div class="pricing-plan__prices__card__price">
                        <?php echo $c['tarif2']; ?>€
                    </div>
                    <div class="pricing-plan__prices__card__animal">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/chiens-chats.svg" alt="Chiens, chats">
                        Chiens, chats
                    </div>
                </div>
            </div>
            <div class="pricing-plan__features">
                <?php if(!is_null($c['avantages']) && !empty($c['avantages']) && is_array($c['avantages'])) : ?>
                <ul>
                    <?php foreach($c['avantages'] as $a) : ?>
                        <li><?php echo $a['text']; ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
            <div class="pricing-plan__button">
                <a href="<?php echo str_replace('"', '\"', $c['link']['url']); ?>" target="<?php echo str_replace('"', '\"', $c['link']['target']); ?>" class="btn btn--arrow"><?php echo $c['link']['title']; ?></a>
            </div>
        </div>
    <?php endforeach; ?>    
</div>
<?php endif; ?>