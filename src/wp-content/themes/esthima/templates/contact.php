<?php if (!defined("ABSPATH")) {
    exit();
} // Exit if accessed directly

/*
 * Template Name: Contact
 */
get_header();
?>


    <main class="main main-content">
        <div class="contact__tet">
            <div class="contact__tet__texts">
                <div class="contact__tet__texts__breadcrumbs">
                    <?php if (function_exists("yoast_breadcrumb")) {
                        yoast_breadcrumb();
                    } ?>
                </div>
                <h1><?php echo get_field("tet_title"); ?></h1>
                <?php get_template_part("template-parts/phone-number"); ?>
                <h3><?php echo get_field("tet_subtitle"); ?></h3>
                <div class="contact__tet__texts__text">
                    <?php echo get_field("tet_text"); ?>
                </div>
                <img src="<?php echo esc_attr(get_field("tet_img")); ?>"
                     alt="<?php echo esc_attr(strip_tags(get_field("tet_title"))); ?>" class="contact__tet__texts__img">
            </div>
            <div class="contact__tet__form" style="max-width:500px">
                <h2>Nous contacter</h2>

                <META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">
                <?php $action_url = sf_var('ACTION_FORM') . '&orgId=' . sf_var('ORGID'); ?>
                <form action="<?php echo esc_url($action_url); ?>" method="POST" id="contactForm">
                    <input type="hidden" name="orgid" value="<?php echo sf_var('ORGID'); ?>"> <input type="hidden"
                                                                                                     name="retURL"
                                                                                                     value="<?php echo get_site_url(); ?>/contact?envoyer=1">

                    <!-- Debugging elements -->
                    <div class="contact__text__names">
                        <div class="contact__text__name">
                            <label for="<?php echo sf_var('salesforce_id_owner_lastname'); ?>"
                                   class="store__infos__contact__subtitle">Nom<span
                                        style="color:#D43B68;">*</span></label>
                            <input class="contact__text__input js-sf-nom"
                                   id="<?php echo sf_var('salesforce_id_owner_lastname'); ?>" maxlength="225"
                                   name="<?php echo sf_var('salesforce_id_owner_lastname'); ?>" size="20" type="text"
                                   placeholder="Nom" required/>
                        </div>
                        <div class="contact__text__firstname">
                            <label for="<?php echo sf_var('salesforce_id_owner_firstname'); ?>"
                                   class="store__infos__contact__subtitle">Prénom<span
                                        style="color:#D43B68;">*</span></label>
                            <input class="contact__text__input js-sf-prenom"
                                   id="<?php echo sf_var('salesforce_id_owner_firstname'); ?>" maxlength="225"
                                   name="<?php echo sf_var('salesforce_id_owner_firstname'); ?>" size="20" type="text"
                                   placeholder="Prénom" required/>
                        </div>
                    </div>

                    <label for="<?php echo sf_var('salesforce_id_email'); ?>" class="store__infos__contact__subtitle">Email<span
                                style="color:#D43B68;">*</span></label>
                    <input class="contact__text__input js-sf-email" id="<?php echo sf_var('salesforce_id_email'); ?>"
                           maxlength="80" name="<?php echo sf_var('salesforce_id_email'); ?>" size="20"
                           type="text" placeholder="Email" required/>

                    <label for="<?php echo sf_var('salesforce_id_tel'); ?>" class="store__infos__contact__subtitle">Téléphone<span
                                style="color:#D43B68;">*</span></label>
                    <input class="contact__text__input js-sf-tel" id="<?php echo sf_var('salesforce_id_tel'); ?>"
                           maxlength="40" name="<?php echo sf_var('salesforce_id_tel'); ?>" size="20" type="text"
                           placeholder="Téléphone" required/>

                    <label style="display:none;" for="<?php echo sf_var('salesforce_id_type'); ?>"
                           class="store__infos__contact__subtitle">Type<span
                                style="color:#D43B68;">*</span></label>
                    <select style="display:none;" class="contact__text__input contact__form__select" id="type"
                            name="type" required>
                        <option value="Esthima">Esthima</option>
                    </select>

                    <!-- Type de demande (fixe, donc classe custom pour le JS) -->
                    <label for="<?php echo sf_var('salesforce_id_type'); ?>" class="store__infos__contact__subtitle">Type
                        de demande<span
                                style="color:#D43B68;">*</span></label>
                    <select class="contact__text__input contact__form__select js-sf-typedemande"
                            id="<?php echo sf_var('salesforce_id_type'); ?>"
                            name="<?php echo sf_var('salesforce_id_type'); ?>"
                            title="Type de demande" required>
                        <option value="">Type de demande</option>
                        <option value="Commande de produits">Commande de produits</option>
                        <option value="Commande de service de crémation">Commande de service de crémation</option>
                        <option value="Demande d'informations">Demande d'informations</option>
                        <option value="Prise de rendez-vous">Prise de rendez-vous</option>
                        <option value="Réclamation">Réclamation</option>
                        <option value="Remerciements">Remerciements</option>
                    </select>

                    <!-- Sous-type (dynamique : ID côté Salesforce, JS s'en fout) -->
                    <label for="<?php echo sf_var('salesforce_id_subtype'); ?>"
                           class="store__infos__contact__subtitle js-sf-subtype-label" id="subTypeLabel"
                           style="display: none;">Sous type<span style="color:#D43B68;">*</span></label>
                    <select class="contact__text__input contact__form__select js-sf-subtype"
                            id="<?php echo sf_var('salesforce_id_subtype'); ?>"
                            name="<?php echo sf_var('salesforce_id_subtype'); ?>" title="Sous type"
                            style="display: none;" required>
                        <option value="">Sous type</option>
                    </select>

                    <input id="subject" name="subject" type="hidden" required/>

                    <label for="description" class="store__infos__contact__subtitle">Description<span
                                style="color:#D43B68;">*</span></label>
                    <textarea class="contact__text__input contact__text__area js-sf-description" name="description"
                              rows="6" placeholder="Description" required></textarea>

                    <input type="hidden" name="<?php echo sf_var('salesforce_id_city'); ?>"
                           value="Villeneuve d&#39;ascq">

                    <!-- RGPD / opt-in -->
                    <div class="store__infos__contact__subtitle"
                         style="margin: 1em 0;display: flex;align-items: flex-start;">
                        <input id="<?php echo sf_var('salesforce_id_rgpd'); ?>"
                               name="<?php echo sf_var('salesforce_id_rgpd'); ?>"
                               class="js-sf-rgpd"
                               type="checkbox"
                               value="1"
                               required/>
                        <label for="tech_rgpd" style="text-transform: none;">
                            En cochant cette case, j'accepte que les informations personnelles que je communique
                            puissent être utilisées pour recevoir des communications à caractère général ou commercial
                            de la part de Esthima et des autres marques de l'entreprise Incinéris SASU.<span
                                    style="color:#D43B68;">*</span>
                        </label>
                    </div>

                    <div class="cf-turnstile" data-sitekey="0x4AAAAAAA5NewCJIpYHWGb5"></div>

                    <input type="hidden" id="external" name="external" value="1"/>

                    <p style="text-align:right;"><span style="color:#D43B68;">*</span> Champs obligatoires</p>

                    <button class="contact__submit" type="submit" name="submit">
                        Envoyer
                        <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right-white.svg"
                             class="contact__submit__arrow" alt="arrow"/>
                    </button>

                </form>

                <div id="thankYouMessage" style="display: none;">
                    Merci de nous avoir contactés ! Nous vous répondrons sous peu.
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const typeSelect = document.querySelector('.js-sf-typedemande');
                        const subTypeSelect = document.querySelector('.js-sf-subtype');
                        const subTypeLabel = document.querySelector('.js-sf-subtype-label');

                        const subTypesOptions = {
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
                                "Autres", "Devis", "Explications supplémentaires", "Facturation",
                                "Paiement", "Rendez-vous", "RGPD", "Services et produits additionnels", "Tarification"
                            ],
                            "Mise à jour administrative": [
                                "Changement de coordonnées"
                            ],
                            "Prise de rendez-vous": [
                                "Prise de rendez-vous"
                            ],
                            "Réclamation": [
                                "Produit", "Service", "Facturation", "Expérience client"
                            ],
                            "Remerciements": [
                                "Remerciements"
                            ]
                        };

                        if (typeSelect && subTypeSelect && subTypeLabel) {
                            typeSelect.addEventListener('change', function () {
                                const selectedType = typeSelect.value;
                                const subTypes = subTypesOptions[selectedType] || [];

                                if (selectedType) {
                                    subTypeLabel.style.display = 'block';
                                    subTypeSelect.style.display = 'block';
                                } else {
                                    subTypeLabel.style.display = 'none';
                                    subTypeSelect.style.display = 'none';
                                }

                                // Reset & fill options
                                subTypeSelect.innerHTML = '<option value="">Sous type</option>';
                                subTypes.forEach(function (subType) {
                                    const option = document.createElement('option');
                                    option.value = subType;
                                    option.textContent = subType;
                                    subTypeSelect.appendChild(option);
                                });
                            });
                        }

                        // Maj du subject hidden field
                        const subjectInput = document.getElementById('subject');
                        if (subTypeSelect && subjectInput) {
                            subTypeSelect.addEventListener('change', function () {
                                subjectInput.value = subTypeSelect.value;
                            });
                        }

                        // Remerciement si submit OK
                        const urlParams = new URLSearchParams(window.location.search);
                        if (urlParams.has('envoyer')) {
                            const form = document.getElementById('contactForm');
                            if (form) form.style.display = 'none';
                            const message = document.getElementById('thankYouMessage');
                            if (message) message.style.display = 'block';
                        }

                        // Tracking Analytics (optionnel)
                        const form = document.getElementById('contactForm');
                        if (form && typeSelect) {
                            form.addEventListener('submit', function () {
                                const selectedType = typeSelect.value || 'Non spécifié';
                                window.dataLayer = window.dataLayer || [];
                                window.dataLayer.push({
                                    'event': 'clickSendContact',
                                    'eventCategory': 'Page contact',
                                    'eventAction': 'Envoyer',
                                    'eventLabel': selectedType
                                });
                            });
                        }
                    });
                </script>
            </div>
        </div>
    </main>
<?php
get_footer();
