<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php $faq = get_field('faq'); ?>
<?php if(!is_null($faq) && !empty($faq) && is_array($faq)) : ?>
<ul class="list-faq">
    <?php $currentFAQ = 0; foreach($faq as $f) : ?>
        <li class="list-faq__item <?php echo ($currentFAQ==0) ? 'list-faq__item-open' : 'list-faq__item-closed'; ?>">
            <div class="list-faq__item__question">
                <?php echo get_the_title($f); ?>
            </div>
            <div class="list-faq__item__answer">
                <div class="list-faq__item__answer__content">
                    <?php
                        $myFAQ = get_post($f);
                        echo apply_filters('the_content',$myFAQ->post_content);
                    ?>
                </div>
            </div>
        </li>
    <?php $currentFAQ++; endforeach; ?>
</ul>
<?php endif; ?>