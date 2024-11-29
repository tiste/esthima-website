<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly

/*
* Template Name: Contact
*/
get_header();
?>

<main class="main main-content">

	<div class="contact__tet">
        <div class="contact__tet__texts">
            <div class="contact__tet__texts__breadcrumbs">
                <?php if(function_exists('yoast_breadcrumb')){ yoast_breadcrumb(); } ?>
            </div>
            <h1><?php echo get_field('tet_title'); ?></h1>
            <?php get_template_part('template-parts/phone-number'); ?>
            <h3><?php echo get_field('tet_subtitle'); ?></h3>
            <div class="contact__tet__texts__text">
                <?php echo get_field('tet_text'); ?>
            </div>
            <img src="<?php echo str_replace('"', '\"', get_field('tet_img')); ?>" alt="<?php echo str_replace(array('"', '<span>', '</span>'), array('\"', '', ''), get_field('tet_title')); ?>" class="contact__tet__texts__img">
        </div>
        <div class="contact__tet__form">
            <img src="<?php echo get_template_directory_uri(); ?>/images/close-pink.svg" alt="Fermer" class="contact__tet__form__close">
            <h2>Nous contacter</h2>

			<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">

			<form action="https://cie-veterinaires--pprd.sandbox.my.salesforce.com/servlet/servlet.WebToCase?encoding=UTF-8&orgId=00DAa000006clk5" method="POST" id="contactForm">

				<input type=hidden name="orgid" value="00DAa000006clk5">
				<input type=hidden name="retURL" value="https://www.esthima.fr/contact">

				<!--  ----------------------------------------------------------------------  -->
				<!--  NOTE: These fields are optional debugging elements. Please uncomment    -->
				<!--  these lines if you wish to test in debug mode.                          -->
				<!-- <input type="hidden" name="debug" value=1> -->
				<!-- <input type="hidden" name="debugEmail" value="vo2.incineris@vo2-group.com"> -->
				<!--  ----------------------------------------------------------------------  -->
				<div class="contact__text__names">
				<input class="contact__text__input" id="00NAa00000FLWCP" maxlength="225" name="00NAa00000FLWCP" size="20" type="text" placeholder="Nom" />

				<!-- <br> -->

				<input class="contact__text__input" id="00NAa00000FLWCN" maxlength="225" name="00NAa00000FLWCN" size="20" type="text" placeholder="Prénom" />
				</div>
				<!-- <br> -->

				<!-- <label for="email">Email</label> -->
				<input class="contact__text__input" id="email" maxlength="80" name="email" size="20" type="text" placeholder="Email" />

				<!-- <br> -->

				<!-- <label for="phone">Phone</label> -->
				<input class="contact__text__input" id="phone" maxlength="40" name="phone" size="20" type="text" placeholder="Téléphone" />

				<!-- <br> -->

				<!-- <label for="type">Type</label> -->
				<select class="contact__text__input contact__form__select" id="type" name="type">
					<option value="">Type</option>
					<option value="Crématis">Crématis</option>
					<option value="Esthima">Esthima</option>
					<option value="Esthima Pro">Esthima Pro</option>
					<option value="Cyclavet">Cyclavet</option>
					<option value="Horsia">Horsia</option>
					<option value="SPAM">SPAM</option>
				</select>

				<!-- <br> -->

				<select class="contact__text__input contact__form__select" id="00N2400000J0cws" name="00N2400000J0cws" title="Type de requête">
					<option value="">Type de requête</option>
					<option value="Ajout de consommables">Ajout de consommables</option>
					<option value="Assistance technique">Assistance technique</option>
					<option value="Commande de produits">Commande de produits</option>
					<option value="Commande de service de crémation">Commande de service de crémation</option>
					<option value="Demande d&#39;informations">Demande d&#39;informations</option>
					<option value="Demande de rappel par mon délégué commercial">Demande de rappel par mon délégué commercial</option>
					<option value="Désabonnement du programme de fidélité">Désabonnement du programme de fidélité</option>
					<option value="Documents administratifs">Documents administratifs</option>
					<option value="Mise à jour administrative">Mise à jour administrative</option>
					<option value="Modification administrative">Modification administrative</option>
					<option value="Passage">Passage</option>
					<option value="Prise de rendez-vous">Prise de rendez-vous</option>
					<option value="Réclamation">Réclamation</option>
					<option value="Prise en charge">Prise en charge</option>
					<option value="Remerciements">Remerciements</option>
					<option value="Spam">Spam</option>
					<option value="Suggestions d&#39;améliorations">Suggestions d&#39;améliorations</option>
					<option value="Suivi rétrocession">Suivi rétrocession</option>
					<option value="Track déchet">Track déchet</option>
				</select>

				<!-- <br> -->

				<select class="contact__text__input contact__form__select" id="00NAa00000FLWCX" name="00NAa00000FLWCX" title="Sous type">
					<option value="">Sous type</option>
					<option value="Accompagnement dans l&#39;utilisation">Accompagnement dans l&#39;utilisation</option>
					<option value="Ajout de consommables">Ajout de consommables</option>
					<option value="Annulation d&#39;un passage">Annulation d&#39;un passage</option>
					<option value="Annulation de la commande de produits">Annulation de la commande de produits</option>
					<option value="Annulation de la crémation">Annulation de la crémation</option>
					<option value="Annulation de la prise en charge">Annulation de la prise en charge</option>
					<option value="Autres">Autres</option>
					<option value="BSD">BSD</option>
					<option value="Changement de coordonnées">Changement de coordonnées</option>
					<option value="Changement de coordonnées bancaires">Changement de coordonnées bancaires</option>
					<option value="Changement de modèle commercial">Changement de modèle commercial</option>
					<option value="Clôture">Clôture</option>
					<option value="Connexion">Connexion</option>
					<option value="Demande de dépannage">Demande de dépannage</option>
					<option value="Demande de passage">Demande de passage</option>
					<option value="Demande de prise en charge">Demande de prise en charge</option>
					<option value="Demande de prise en charge à domicile">Demande de prise en charge à domicile</option>
					<option value="Demande de prise en charge à la clinique">Demande de prise en charge à la clinique</option>
					<option value="Demande de prise en charge au crématorium">Demande de prise en charge au crématorium</option>
					<option value="Demande de rappel par mon délégué commercial">Demande de rappel par mon délégué commercial</option>
					<option value="Demande de retour urnes autre site">Demande de retour urnes autre site</option>
					<option value="Désabonnement du programme de fidélité">Désabonnement du programme de fidélité</option>
					<option value="Devis">Devis</option>
					<option value="Disponibilités">Disponibilités</option>
					<option value="Envoi de facture">Envoi de facture</option>
					<option value="Expérience Client">Expérience Client</option>
					<option value="Explications supplémentaires">Explications supplémentaires</option>
					<option value="Facturation">Facturation</option>
					<option value="Fusion">Fusion</option>
					<option value="Information sur le passage">Information sur le passage</option>
					<option value="Modification de la commande de crémation">Modification de la commande de crémation</option>
					<option value="Modification de la commande de produits">Modification de la commande de produits</option>
					<option value="Modification de la prise en charge">Modification de la prise en charge</option>
					<option value="Modification du passage">Modification du passage</option>
					<option value="Paiement">Paiement</option>
					<option value="Prise de rendez vous">Prise de rendez vous</option>
					<option value="Prise en charge">Prise en charge</option>
					<option value="Problème technique">Problème technique</option>
					<option value="Produit">Produit</option>
					<option value="Rachat">Rachat</option>
					<option value="Récapitulatif annuel">Récapitulatif annuel</option>
					<option value="Remerciements">Remerciements</option>
					<option value="Rendez-vous">Rendez-vous</option>
					<option value="RGDP">RGDP</option>
					<option value="Service">Service</option>
					<option value="Services et produits additionnels">Services et produits additionnels</option>
					<option value="Spam">Spam</option>
					<option value="Suggestions d&#39;améliorations">Suggestions d&#39;améliorations</option>
					<option value="Suivi de la commande de produits">Suivi de la commande de produits</option>
					<option value="Suivi de la crémation">Suivi de la crémation</option>
					<option value="Suivi de prise en charge">Suivi de prise en charge</option>
					<option value="Suivi rétrocession">Suivi rétrocession</option>
					<option value="Tarification">Tarification</option>
					<option value="Tarification et tarifs spéciaux">Tarification et tarifs spéciaux</option>
					<option value="Track déchet">Track déchet</option>
				</select>

				<!-- <br> -->

				<!-- <label for="subject">Subject</label> -->
				<input class="contact__text__input contact__text__textarea" id="subject" maxlength="80" name="subject" size="20" type="text" placeholder="Sujet" />

				<!-- <br> -->

				<!-- <label for="description">Description</label> -->
				<textarea class="contact__text__input contact__text__area" name="description" rows="6" placeholder="Description"></textarea>

				<!-- <br> -->

				<input type="hidden"  id="external" name="external" value="1" />

				<!-- <br> -->

				<button class="contact__submit" type="submit" name="submit">
					Envoyer
					<img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right-white.svg" class="contact__submit__arrow" alt="arrow" />
				</button>

			</form>

		</div>
	</div>

</main>


<?php get_footer(); ?>