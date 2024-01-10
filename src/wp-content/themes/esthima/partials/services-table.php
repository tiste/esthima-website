<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php $cremations = get_field('incinerations'); ?>
<?php if(!is_null($cremations) && !empty($cremations) && is_array($cremations)) : ?>
<div class="pricing-table pricing-table--services">
    <?php foreach($cremations as $c) : ?>
        <div class="pricing-plan">
            <div class="pricing-plan__head">
                <div></div>
                <div>La crémation</div>
                <div><?php echo $c['name']; ?></div>
            </div>
            <div class="pricing-plan__features">
                <?php echo $c['desc']; ?>
            </div>
            <div class="pricing-plan__button">
                <a href="<?php echo $c['link']['url']; ?>" target="<?php echo $c['link']['target']; ?>" class="btn btn--arrow btn--arrow--white"><?php echo $c['link']['title']; ?></a>
            </div>
        </div>
    <?php endforeach; ?>
    
</div>
<?php endif; ?>