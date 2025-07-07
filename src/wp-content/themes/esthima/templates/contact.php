<?php if (!defined("ABSPATH")) {
    exit();
} // Exit if accessed directly

/*
 * Template Name: Contact
 */
get_header();
?>

<?php
$isProd = $_SERVER['SERVER_NAME'] == 'esthima.fr' ? true : false;
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
            <img src="<?php echo str_replace(
                '"',
                '\"',
                get_field("tet_img")
            ); ?>" alt="<?php echo str_replace(
    ['"', "<span>", "</span>"],
    ['\"', "", ""],
    get_field("tet_title")
); ?>" class="contact__tet__texts__img">
        </div>
        <div class="contact__tet__form" style="max-width:500px">
            <h2>Nous contacter</h2>

			<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">

			<form action="<?php echo esc_url(get_field('action_form', 'option')); ?>" method="POST" id="contactForm">

				<input type="hidden" name="orgid" value="<?php echo $isProd ? '00D24000000jNFO' : '00DAa000006clk5' ?>">
				<input type="hidden" name="retURL" value="<?php echo get_site_url(); ?>/contact?envoyer=1">

				<!--  Debugging elements  -->
				<!-- <input type="hidden" name="debug" value=1> -->
				<!-- <input type="hidden" name="debugEmail" value="vo2.incineris@vo2-group.com"> -->

				<div class="contact__text__names">
					<div class="contact__text__name">
						<label for="<?php echo $isProd ? '00NbK0000024EGV' : '00NAa00000FLWCP' ?>" class="store__infos__contact__subtitle">Nom<span style="color:#D43B68;">*</span></label>
						<input class="contact__text__input" id="<?php echo $isProd ? '00NbK0000024EGV' : '00NAa00000FLWCP' ?>" maxlength="225" name="<?php echo $isProd ? '00NbK0000024EGV' : '00NAa00000FLWCP' ?>" size="20" type="text" placeholder="Nom" required/>
					</div>

					<div class="contact__text__firstname">
						<label for="<?php echo $isProd ? '00NbK0000024EGT' : '00NAa00000FLWCN' ?>" class="store__infos__contact__subtitle">Prénom<span style="color:#D43B68;">*</span></label>
						<input class="contact__text__input" id="<?php echo $isProd ? '00NbK0000024EGT' : '00NAa00000FLWCN' ?>" maxlength="225" name="<?php echo $isProd ? '00NbK0000024EGT' : '00NAa00000FLWCN' ?>" size="20" type="text" placeholder="Prénom" required/>
					</div>
				</div>

				<label for="email" class="store__infos__contact__subtitle">Email<span style="color:#D43B68;">*</span></label>
				<input class="contact__text__input" id="email" maxlength="80" name="email" size="20" type="text" placeholder="Email" required/>

				<label for="<?php echo $isProd ? '00NbK0000024EGX' : '00NAa00000FLWCQ' ?>" class="store__infos__contact__subtitle">Téléphone<span style="color:#D43B68;">*</span></label>
				<input class="contact__text__input" id="<?php echo $isProd ? '00NbK0000024EGX' : '00NAa00000FLWCQ' ?>" maxlength="40" name="<?php echo $isProd ? '00NbK0000024EGX' : '00NAa00000FLWCQ' ?>" size="20" type="text" placeholder="Téléphone" required/>

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


				<label for="<?php echo $isProd ? '00NbK0000024EHH' : '00NAa00000FLWCX' ?>" class="store__infos__contact__subtitle" id="sousTypeLabel" style="display: none;">Sous type<span style="color:#D43B68;">*</span></label>
				<select class="contact__text__input contact__form__select" id="<?php echo $isProd ? '00NbK0000024EHH' : '00NAa00000FLWCX' ?>" name="<?php echo $isProd ? '00NbK0000024EHH' : '00NAa00000FLWCX' ?>" title="Sous type" style="display: none;"required>
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
				const sousTypeSelect = document.getElementById('<?php echo $isProd ? '00NbK0000024EHH' : '00NAa00000FLWCX' ?>');
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

				<input type=hidden name="<?php echo $isProd ? '00NbK000002Kzar' : '00NAa00000LhU6n' ?>" value="Villeneuve d&#39;ascq">

				<!-- RGPD / opt-in -->
				<div class="store__infos__contact__subtitle" style="margin: 1em 0;display: flex;align-items: flex-start;">
					<input id="<?php echo $isProd ? '00NbK00000BgC85' : '00NAa00000M7LYX' ?>"
						name="<?php echo $isProd ? '00NbK00000BgC85' : '00NAa00000M7LYX' ?>"
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
				const sousTypeSelect = document.getElementById('<?php echo $isProd ? '00NbK0000024EHH' : '00NAa00000FLWCX' ?>');
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

			document.addEventListener('DOMContentLoaded', function() {
				const form = document.getElementById('contactForm');
				const typeSelect = document.getElementById('00N2400000J0cws'); // Sélecteur du type de demande

				if (form && typeSelect) {
					form.addEventListener('submit', function() {
						const selectedType = typeSelect.value || 'Non spécifié'; // Valeur sélectionnée ou fallback

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