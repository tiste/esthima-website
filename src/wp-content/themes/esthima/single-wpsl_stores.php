<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	get_header();
?>

<main class="main" itemscope itemtype="http://schema.org/LocalBusiness">

    <div class="store__tet" style="--bg-img: url('<?php echo (!empty(get_the_post_thumbnail_url())) ? get_the_post_thumbnail_url() : get_template_directory_uri().'/images/default-store.jpg'; ?>');">
        <div class="store__tet__background">
            <img src="<?php echo (!empty(get_the_post_thumbnail_url())) ? str_replace('"', '\"', get_the_post_thumbnail_url()) : str_replace('"', '\"', get_template_directory_uri()).'/images/default-store.jpg'; ?>" alt="<?php echo str_replace('"', '\"', get_the_title()); ?>" itemprop="image">
        </div>
        <div class="storeloc__tet__breadcrumbs">
            <span itemscope itemtype="https://schema.org/BreadcrumbList">
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="<?php echo home_url(); ?>" itemprop="item"><span itemprop="name">Accueil</span></a>
                    <meta itemprop="position" content="1" />
                </span> &gt;
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="<?php echo home_url('/'); ?>crematoriums" itemscope itemtype="https://schema.org/WebPage" itemprop="item" itemid="<?php echo home_url('/'); ?>crematoriums"><span itemprop="name">Nos agences et crématoriums</span></a>
                    <meta itemprop="position" content="2" />
                </span> &gt;
                <span class="breadcrumb_last" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name"><?php echo get_the_title(); ?></span>
                    <meta itemprop="position" content="3" />
                </span>
            </span>
        </div>
        <div class="main-content">
            <div class="store__tet__container">
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
                <h1 itemprop="name"><?php echo $typeStr; ?> de <span><?php echo get_the_title(); ?></span></h1>
                <div class="store__tet__btns">
                    <a href="<?php echo home_url('/'); ?>configurateur" class="btn btn--arrow">Personnaliser les obsèques</a>
                    <a href="<?php echo home_url('/'); ?>prendre-rdv" class="store__tet__btns__rdv">Prendre rendez-vous</a>
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
                    <META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">

                    <form action="<?php echo esc_url(get_field('action_form', 'option'));?>" method="POST" id="contactForm">

                        <input type="hidden" name="orgid" value="<?php echo get_field('orgid', 'option') ?>">

                        <?php 
                        $permalink = get_permalink( get_the_ID() );?>
                        <input type="hidden" name="retURL" value="<?php echo esc_url( $permalink ); ?>?envoyer=1">

                        <!--  Debugging elements  -->
                        <!-- <input type="hidden" name="debug" value=1> -->
                        <!-- <input type="hidden" name="debugEmail" value="vo2.incineris@vo2-group.com"> -->

                        <div class="contact__text__names">
                            <div class="contact__text__name">
                                <label for="00NAa00000FLWCP" class="store__infos__contact__subtitle">Nom<span style="color:#D43B68;">*</span></label>
                                <input class="contact__text__input" id="00NAa00000FLWCP" maxlength="225" name="00NAa00000FLWCP" size="20" type="text" placeholder="Nom" required/>
                            </div>

                            <div class="contact__text__firstname">
                                <label for="00NAa00000FLWCN" class="store__infos__contact__subtitle">Prénom<span style="color:#D43B68;">*</span></label>
                                <input class="contact__text__input" id="00NAa00000FLWCN" maxlength="225" name="00NAa00000FLWCN" size="20" type="text" placeholder="Prénom" required/>
                            </div>
                        </div>

                        <label for="email" class="store__infos__contact__subtitle">Email<span style="color:#D43B68;">*</span></label>
                        <input class="contact__text__input" id="email" maxlength="80" name="email" size="20" type="text" placeholder="Email" required/>

                        <label for="phone" class="store__infos__contact__subtitle">Téléphone<span style="color:#D43B68;">*</span></label>
                        <input class="contact__text__input" id="phone" maxlength="40" name="phone" size="20" type="text" placeholder="Téléphone" required/>

                        <label style="display:none;" for="00N2400000J0cws" class="store__infos__contact__subtitle">Type<span style="color:#D43B68;">*</span></label>
                        <select style="display:none;" class="contact__text__input contact__form__select" id="type" name="type" required>
                            <option value="Esthima">Esthima</option>
                        </select>


                        <label for="00N2400000J0cws" class="store__infos__contact__subtitle">Type de demande<span style="color:#D43B68;">*</span></label>
                        <select class="contact__text__input contact__form__select" id="00N2400000J0cws" name="00N2400000J0cws" title="Type de demande" required>
                        <option value="">Type de demande</option>
                        <option value="Commande de produits">Commande de produits</option>
                        <option value="Commande de service de crémation">Commande de service de crémation</option>
                        <option value="Demande d'informations">Demande d'informations</option>
                        <option value="Prise de rendez-vous">Prise de rendez-vous</option>
                        <option value="Réclamation">Réclamation</option>
                        <option value="Remerciements">Remerciements</option>
                        </select>


                        <label for="00NAa00000FLWCX" class="store__infos__contact__subtitle" id="sousTypeLabel" style="display: none;">Sous type<span style="color:#D43B68;">*</span></label>
                        <select class="contact__text__input contact__form__select" id="00NAa00000FLWCX" name="00NAa00000FLWCX" title="Sous type" style="display: none;" required>
                        <option value="">Sous type</option>
                        </select>

                        <script>
                        const sousTypesOptions = {
                            "Commande de produits": [
                            "Annulation de la commande de produits",
                            "Modification de la commande de produits",
                            "Suivi de la commande de produits"
                            ],
                            "Commande de service de crémation": [
                            "Annulation de la crémation",
                            "Modification de la commande de crémation",
                            "Suivi de la crémation"
                            ],
                            "Demande d'informations": [
                            "Autres",
                            "Devis",
                            "Explications supplémentaires",
                            "Facturation",
                            "Paiement",
                            "Rendez-vous",
                            "RGPD",
                            "Services et produits additionnels",
                            "Tarification"
                            ],
                            "Mise à jour administrative": [
                            "Changement de coordonnées"
                            ],
                            "Prise de rendez-vous": [
                            "Prise de rendez-vous"
                            ],
                            "Réclamation": [
                            "Produit",
                            "Service",
                            "Facturation",
                            "Expérience client"
                            ],
                            "Remerciements": [
                            "Remerciements"
                            ]
                        };

                        const typeSelect = document.getElementById('00N2400000J0cws');
                        const sousTypeSelect = document.getElementById('00NAa00000FLWCX');
                        const sousTypeLabel = document.getElementById('sousTypeLabel');

                        typeSelect.addEventListener('change', function() {
                            const selectedType = typeSelect.value;
                            const sousTypes = sousTypesOptions[selectedType] || [];

                            if (selectedType) {
                            sousTypeLabel.style.display = 'block';
                            sousTypeSelect.style.display = 'block';
                            } else {
                            sousTypeLabel.style.display = 'none';
                            sousTypeSelect.style.display = 'none';
                            }

                            // Clear previous options
                            sousTypeSelect.innerHTML = '<option value="">Sous type</option>';

                            // Populate new options
                            sousTypes.forEach(function(sousType) {
                            const option = document.createElement('option');
                            option.value = sousType;
                            option.textContent = sousType;
                            sousTypeSelect.appendChild(option);
                            });
                        });
                        </script>

                        <input id="subject" name="subject" type="hidden" required />

                        <label for="description" class="store__infos__contact__subtitle">Description<span style="color:#D43B68;">*</span></label>
                        <textarea class="contact__text__input contact__text__area" name="description" rows="6" placeholder="Description" required></textarea>

                        <!-- RGPD / opt-in -->
                        <div class="store__infos__contact__subtitle" style="margin: 1em 0;display: flex;align-items: flex-start;">
                            <input id="00NAa00000M7LYX"
                                name="00NAa00000M7LYX"
                                type="checkbox"
                                value="1"
                                required />
                            <label for="tech_rgpd" style="text-transform: none;">
                            En cochant cette case, j'accepte que les informations personnelles que je communique 
                            puissent être utilisées pour recevoir des communications à caractère général ou commercial 
                            de la part de Esthima et des autres marques de l'entreprise Incinéris SASU.<span style="color:#D43B68;">*</span>
                            </label>
                        </div>

                        <div class="cf-turnstile" data-sitekey="0x4AAAAAAA5NewCJIpYHWGb5"></div>

                        <input type="hidden" id="external" name="external" value="1" />

                        <p style="text-align:right;"><span style="color:#D43B68;">*</span> Champs obligatoires</p>

                        <button class="contact__submit" type="submit" name="submit">
                            Envoyer
                            <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right-white.svg" class="contact__submit__arrow" alt="arrow" />
                        </button>

                    </form>

                    <!-- Conteneur pour le message de remerciement (initialement vide ou masqué) -->
                    <div id="thankYouMessage" style="display: none;">
                    Merci de nous avoir contactés ! Nous vous répondrons sous peu.
                    </div>

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const sousTypeSelect = document.getElementById('00NAa00000FLWCX');
                        const subjectInput = document.getElementById('subject');

                        sousTypeSelect.addEventListener('change', function() {
                            subjectInput.value = sousTypeSelect.value;
                        });
                    });
                    document.addEventListener('DOMContentLoaded', function() {
                        // Récupération des paramètres de l’URL
                        const urlParams = new URLSearchParams(window.location.search);
                        
                        // Vérification de l’existence du paramètre "envoyer"
                        if (urlParams.has('envoyer')) {
                        // Masquer le formulaire
                        const form = document.getElementById('contactForm');
                        if (form) {
                            form.style.display = 'none';
                        }

                        // Afficher le message de remerciement
                        const message = document.getElementById('thankYouMessage');
                        if (message) {
                            message.style.display = 'block';
                        }
                        }
                    });
                    </script>

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