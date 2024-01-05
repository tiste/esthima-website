<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	get_header();
?>

<main class="main" itemscope itemtype="http://schema.org/LocalBusiness">

    <div class="store__tet" style="--bg-img: url('<?php echo (!empty(get_the_post_thumbnail_url())) ? get_the_post_thumbnail_url() : get_template_directory_uri().'/images/default-store.jpg'; ?>');">
        <div class="storeloc__tet__breadcrumbs">
            <?php if(function_exists('yoast_breadcrumb')){ yoast_breadcrumb(); } ?>
        </div>
        <div class="main-content">
            <div class="store__tet__container">
                <div class="store__tet__status"></div>
                <?php
                    $types = get_the_terms( get_the_ID(), 'wpsl_store_category' );
                    $typeStr = '';
                    if ( $types ) {
                        if ( ! is_wp_error( $types ) ) {
                            if ( count( $types ) > 1 ) {
                                $location_types = array();
                                foreach ( $types as $term ) {
                                    $location_types[] = $term->name;
                                }
                                $typeStr = implode( ', ', $location_types );
                            } else {
                                $typeStr = $types[0]->name;
                            }
                        }
                    }
                ?>
                <h1><?php echo $typeStr; ?> de <span><?php echo get_the_title(); ?></span></h1>
                <div class="store__tet__btns">
                    <a href="#" class="btn btn--arrow">Personnaliser les obsèques</a>
                    <a href="<?php echo home_url('/'); ?>prendre-rdv/" class="store__tet__btns__rdv">Prendre rendez-vous</a>
                    <a href="tel:<?php echo get_post_meta(get_the_ID(), 'wpsl_phone', true); ?>" class="store__tet__btns__call">Nous appeler</a>
                </div>
            </div>
        </div>
    </div>

    <div class="store__infos lightBG">
        <div class="main-content">
            <div class="store__infos__container">
                <div class="store__infos__infos">
                    <h2><?php echo get_field('store_infos_title'); ?></h2>
                    <div class="store__infos__infos__text">
                        <?php echo get_field('store_infos_text'); ?>
                    </div>
                    <h2>Infos pratiques</h2>
                    <div class="store__infos__infos__flex">
                        <div class="store__infos__infos__flex__item store__infos__infos__flex__item-address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                            <span itemprop="streetAddress"><?php echo get_post_meta(get_the_ID(), 'wpsl_address', true); ?></span>
                            <span><?php echo get_post_meta(get_the_ID(), 'wpsl_address2', true); ?></span>
                            <span><span itemprop="postalCode"><?php echo get_post_meta(get_the_ID(), 'wpsl_zip', true); ?></span> <span style="display: inline" itemprop="addressLocality"><?php echo get_post_meta(get_the_ID(), 'wpsl_city', true); ?></span></span>
                        </div>
                        <div class="store__infos__infos__flex__item store__infos__infos__flex__item-hours" itemprop="openingHours">
                            <?php
                                $hours = get_post_meta(get_the_ID(), 'wpsl_hours', true);
                                $horaires = array();
                                $currentDayStart = 'lundi';
                                $currentDayEnd = 'lundi';
                                $currentHorraires = $hours['monday'];
                                $daysMap = [
                                    'monday' => 'lundi',
                                    'tuesday' => 'mardi',
                                    'wednesday' => 'mercredi',
                                    'thursday' => 'jeudi',
                                    'friday' => 'vendredi',
                                    'saturday' => 'samedi',
                                    'sunday' => 'dimanche'
                                ];
                                foreach($hours as $key => $h){
                                    $keyFr = $daysMap[$key];
                                    if($h!=$currentHorraires){
                                        $horaires[] = (object) [
                                            'start' => $currentDayStart,
                                            'end' => $currentDayEnd,
                                            'horaires' => $currentHorraires
                                        ];
                                        $currentDayStart = $keyFr;
                                        $currentDayEnd = $keyFr;
                                        $currentHorraires = $h;
                                    }else{
                                        $currentDayEnd = $keyFr;
                                    }
                                }
                                $horaires[] = (object) [
                                    'start' => $currentDayStart,
                                    'end' => $currentDayEnd,
                                    'horaires' => $currentHorraires
                                ];
                            ?>
                            <?php foreach($horaires as $h) : if(!empty($h->horaires)) : ?>
                            <span>
                                <?php if($h->start==$h->end) : ?>
                                    Le <?php echo $h->start; ?>
                                <?php else : ?>
                                    Du <?php echo $h->start; ?> au <?php echo $h->end; ?>
                                <?php endif; ?>
                                :
                                <?php foreach($h->horaires as $key => $heures) : ?><?php echo ($key>0) ? ', ' : ''; $heuresStr = explode(',', $heures); ?>de <?php echo $heuresStr[0]; ?> à <?php echo $heuresStr[1]; ?><?php endforeach; ?>
                            </span>
                            <?php endif; endforeach; ?>
                            <?php if(!empty(get_field('store_closed'))) : ?>
                            <span class="closed-except">Fermeture exceptionnelle :</span>
                            <span><?php echo get_field('store_closed'); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="store__infos__infos__map">
                        <?php echo do_shortcode( '[wpsl_map height="336" zoom="15"]' ); ?>
                    </div>
                </div>
                <div class="store__infos__contact-cta">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/email-contact.svg" alt="Contact">
                </div>
                <div class="store__infos__contact">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/close-pink.svg" alt="Fermer" class="store__infos__contact__close">
                    <div class="store__infos__contact__title">
                        Nous contacter
                    </div>
                    <?php
                        $contactEmail = get_post_meta(get_the_ID(), 'wpsl_email', true);
                        echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true" field_values="sendemail='.$contactEmail.'"]');
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php $gallery = get_field('store_gallery'); ?>
    <?php if(!is_null($gallery) && !empty($gallery) && is_array($gallery)) : ?>
    <div class="main-content">
        <div class="store__gallery">
            <h2>Découvrez <?php echo ($typeStr[0]=="A" || $typeStr[0]=="E" || $typeStr[0]=="I" || $typeStr[0]=="O" || $typeStr[0]=="U" || $typeStr[0]=="Y" || $typeStr[0]=="a" || $typeStr[0]=="e" || $typeStr[0]=="i" || $typeStr[0]=="o" || $typeStr[0]=="u" || $typeStr[0]=="y") ? "l'" : 'le '; echo $typeStr; ?> de <?php echo get_the_title(); ?></h2>
            <div class="store__gallery__slider swiper">
                <div class="swiper-wrapper">
                    <?php foreach($gallery as $g) : ?>
                        <div class="swiper-slide">
                            <img src="<?php echo $g['image']; ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="store__gallery__slider__prev swiper-button-prev"></div>
                <div class="store__gallery__slider__next swiper-button-next"></div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="main-content">

        <?php
            $store_confort = get_field('store_confort');
            $store_services = get_field('store_services');
        ?>
        <?php if((!is_null($store_confort) && !empty($store_confort) && is_array($store_confort)) || (!is_null($store_services) && !empty($store_services) && is_array($store_services))) : ?>
        <div class="store__services">
            <h2>Services disponibles</h2>
            <?php if(!is_null($store_confort) && !empty($store_confort) && is_array($store_confort)) : ?>
            <h3>Commodités / Confort</h3>
            <div class="store__services__flex">
                <?php foreach($store_confort as $s) : ?>
                    <div class="store__services__flex__item">
                        <img src="<?php echo str_replace('"', '\"', get_the_post_thumbnail_url($s)); ?>" alt="<?php echo str_replace('"', '\"', get_the_title($s)); ?>">
                        <?php echo get_the_title($s); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php if(!is_null($store_services) && !empty($store_services) && is_array($store_services)) : ?>
            <h3>Services</h3>
            <div class="store__services__flex">
                <?php foreach($store_services as $s) : ?>
                    <div class="store__services__flex__item">
                        <img src="<?php echo str_replace('"', '\"', get_the_post_thumbnail_url($s)); ?>" alt="<?php echo str_replace('"', '\"', get_the_title($s)); ?>">
                        <?php echo get_the_title($s); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php $linkLeft = get_field('agence_left_link', 'option'); $linkRight = get_field('agence_right_link', 'option'); ?>
        <div class="store__blocks">
            <div class="store__blocks__item lightBG">
                <h3><?php echo get_field('agence_left_surtitle', 'option'); ?></h3>
                <h2><?php echo get_field('agence_left_title', 'option'); ?></h2>
                <div class="store__blocks__item__text">
                    <?php echo get_field('agence_left_text', 'option'); ?>
                </div>
                <img src="<?php echo str_replace('"', '\"', get_field('agence_left_img', 'option')); ?>" alt="<?php echo str_replace('"', '\"', get_field('agence_left_title', 'option')); ?>" class="store__blocks__item__img">
                <?php if(!is_null($linkLeft) && !empty($linkLeft) && is_array($linkLeft)) : ?>
                <a href="<?php echo $linkLeft['url']; ?>" target="<?php echo $linkLeft['target']; ?>" class="btn btn--arrow"><?php echo $linkLeft['title']; ?></a>
                <?php endif; ?>
            </div>
            <div class="store__blocks__item lightBG">
                <img src="<?php echo str_replace('"', '\"', get_field('agence_right_img', 'option')); ?>" alt="<?php echo str_replace('"', '\"', get_field('agence_right_title', 'option')); ?>" class="store__blocks__item__logo">
                <h2><?php echo get_field('agence_right_title', 'option'); ?></h2>
                <div class="store__blocks__item__text">
                    <?php echo get_field('agence_right_text', 'option'); ?>
                </div>
                <?php if(!is_null($linkRight) && !empty($linkRight) && is_array($linkRight)) : ?>
                <a href="<?php echo $linkRight['url']; ?>" target="<?php echo $linkRight['target']; ?>" class="btn btn--arrow"><?php echo $linkRight['title']; ?></a>
                <?php endif; ?>
            </div>
        </div>

    </div>
    
</main>

<script>
    <?php 
        date_default_timezone_set('Europe/Paris');
        $currentDateTime = date('Y-m-d H:i:s', time());
    ?>
    window.todayDate = new Date('<?php echo $currentDateTime; ?>');
    window.arrayDaysMap = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    window.arrayHours = <?php echo json_encode($hours); ?>;
</script>

<?php get_footer(); ?>