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
        <div class="contact__tet__form">
            <h2>Nous contacter</h2>

			<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">

			<form action="https://cie-veterinaires--pprd.sandbox.my.salesforce.com/servlet/servlet.WebToCase?encoding=UTF-8&orgId=00DAa000006clk5" method="POST" id="contactForm">

				<input type="hidden" name="orgid" value="00DAa000006clk5">
				<input type="hidden" name="retURL" value="https://www.esthima.fr/contact">

				<!--  Debugging elements  -->
				<!-- <input type="hidden" name="debug" value=1> -->
				<!-- <input type="hidden" name="debugEmail" value="vo2.incineris@vo2-group.com"> -->

				<div class="contact__text__names">
					<div class="contact__text__name">
						<label for="00NAa00000FLWCP" class="store__infos__contact__subtitle">Nom</label>
						<input class="contact__text__input" id="00NAa00000FLWCP" maxlength="225" name="00NAa00000FLWCP" size="20" type="text" placeholder="Nom" />
					</div>

					<div class="contact__text__firstname">
						<label for="00NAa00000FLWCN" class="store__infos__contact__subtitle">Prénom</label>
						<input class="contact__text__input" id="00NAa00000FLWCN" maxlength="225" name="00NAa00000FLWCN" size="20" type="text" placeholder="Prénom" />
					</div>
				</div>

				<label for="email" class="store__infos__contact__subtitle">Email</label>
				<input class="contact__text__input" id="email" maxlength="80" name="email" size="20" type="text" placeholder="Email" />

				<label for="phone" class="store__infos__contact__subtitle">Téléphone</label>
				<input class="contact__text__input" id="phone" maxlength="40" name="phone" size="20" type="text" placeholder="Téléphone" />

				<label style="display:none;" for="00N2400000J0cws" class="store__infos__contact__subtitle">Type</label>
				<select style="display:none;" class="contact__text__input contact__form__select" id="type" name="type">
					<option value="Esthima">Esthima</option>
				</select>


				<label for="00N2400000J0cws" class="store__infos__contact__subtitle">Type de demande</label>
				<select class="contact__text__input contact__form__select" id="00N2400000J0cws" name="00N2400000J0cws" title="Type de demande">
				<option value="">Type de demande</option>
				<option value="Assistance technique">Assistance technique</option>
				<option value="Commande de produits">Commande de produits</option>
				<option value="Commande de service de crémation">Commande de service de crémation</option>
				<option value="Demande d'informations">Demande d'informations</option>
				<option value="Mise à jour administrative">Mise à jour administrative</option>
				<option value="Prise de rendez-vous">Prise de rendez-vous</option>
				<option value="Réclamation">Réclamation</option>
				<option value="Prise en charge">Prise en charge</option>
				<option value="Remerciements">Remerciements</option>
				<option value="Spam">Spam</option>
				</select>


				<label for="00NAa00000FLWCX" class="store__infos__contact__subtitle" id="sousTypeLabel" style="display: none;">Sous type</label>
				<select class="contact__text__input contact__form__select" id="00NAa00000FLWCX" name="00NAa00000FLWCX" title="Sous type" style="display: none;">
				<option value="">Sous type</option>
				</select>

				<script>
				const sousTypesOptions = {
					"Assistance technique": [
					"Accompagnement dans l'utilisation",
					"Connexion",
					"Problème technique"
					],
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
					"Prise en charge": [
					"Annulation de la prise en charge",
					"Demande de prise en charge à domicile",
					"Demande de prise en charge à la clinique",
					"Demande de prise en charge au crématorium",
					"Suivi de prise en charge"
					],
					"Réclamation": [
					"Produit",
					"Service",
					"Facturation",
					"Expérience client"
					],
					"Remerciements": [
					"Remerciements"
					],
					"Spam": [
					"Spam"
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


				<label for="subject" class="store__infos__contact__subtitle">Sujet</label>
				<input class="contact__text__input contact__text__textarea" id="subject" maxlength="80" name="subject" size="20" type="text" placeholder="Sujet" />

				<label for="description" class="store__infos__contact__subtitle">Description</label>
				<textarea class="contact__text__input contact__text__area" name="description" rows="6" placeholder="Description"></textarea>

				<input type="hidden" id="external" name="external" value="1" />

				<button class="contact__submit" type="submit" name="submit">
					Envoyer
					<img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right-white.svg" class="contact__submit__arrow" alt="arrow" />
				</button>

			</form>

		</div>
	</div>

</main>

<?php
get_footer();