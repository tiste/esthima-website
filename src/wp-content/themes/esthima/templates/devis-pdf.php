<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// $ceremoniePrice = 0;
// if (isset($args['ceremonie_adieu'])) {
//     if ((isset($args['espece'])) && ) {
//         $ceremoniePrice =
//     }
// }


?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="UTF-8">
</head>

<body <?php body_class(); ?> style="font-family: Arial, sans-serif; color: #151515;">
<div style="margin-bottom: 30px; text-align: center;">
    <!-- <img src="<?php echo get_template_directory_uri() . '/images/configurateur/logo_esthima.png'; ?>" alt=""> -->
    <img style="max-width: 230px; height: auto;" src="https://www.esthima.fr/wp-content/uploads/2023/09/logo-esthima_1.png" alt="">
</div>
    <p style="margin: 0;">
        <strong>Nom:</strong> <?php echo (isset($args['nom_personne'])) ? $args['nom_personne'] : ''; ?>
    </p>
    <p style="margin: 0;">
        <strong>Prénom:</strong> <?php echo (isset($args['prenom_personne'])) ? $args['prenom_personne'] : ''; ?>
    </p>
    <p style="margin: 0;">
        <strong>Email:</strong> <?php echo (isset($args['email'])) ? $args['email'] : ''; ?>
    </p>
    <p style="margin: 20px 0;">
        Le coût* estimé des obsèques de votre animal avoisinerait :
    </p>
</div>
<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-family: Arial, sans-serif;">
    <tr>
        <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left;">Espèce</th>
        <td style="border: 1px solid #ddd; padding: 8px; text-transform: capitalize;"><?php echo (isset($args['espece'])) ? $args['espece'] : ''; ?></td>
    </tr>
    <tr>
        <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left;">Nom</th>
        <td style="border: 1px solid #ddd; padding: 8px; text-transform: capitalize;"><?php echo (isset($args['nom'])) ? $args['nom'] : ''; ?></td>
    </tr>
    <tr>
        <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left;">Prix de la crémation</th>
        <td style="border: 1px solid #ddd; padding: 8px;">
            <?php
            $prix_base_cremation = 0;
            if (isset($args['espece'])) {
                if ($args['espece'] == 'chien') $prix_base_cremation = 105;
                else if ($args['espece'] == 'chat') $prix_base_cremation = 105;
                else if ($args['espece'] == 'nac') $prix_base_cremation = 75;
            }
            echo $prix_base_cremation . '€ TTC';
            ?>
        </td>
    </tr>
    <tr>
        <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left;">Récupération des cendres</th>
        <td style="border: 1px solid #ddd; padding: 8px;">
            <?php echo (isset($args['recuperation_cendres']) && $args['recuperation_cendres']) ? 'Oui (' . $args['prix_cendres'] . '€ TTC)'  : 'Non'; ?>
        </td>
    </tr>
    <tr>
        <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left;">Cérémonie d'adieu</th>
        <td style="border: 1px solid #ddd; padding: 8px;">
            <?php echo (isset($args['ceremonie_adieu'])) ? $args['ceremonie_adieu'] . ' (' . $args['prix_ceremonie'] . '€ TTC)' : ''; ?>
        </td>
    </tr>
    <tr>
        <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left;">Urne</th>
        <td style="border: 1px solid #ddd; padding: 8px;">
			<?php echo (isset($args['urne']) && $args['urne'] !== 'Non') ? str_replace(['(', ')'], '', $args['urne']) . ' (' . $args['prix_urne'] . '€ TTC)' : $args['urne']; ?>

        </td>
    </tr>
	<tr>
		<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left;">Geste souvenir</th>
		<td style="border: 1px solid #ddd; padding: 8px;">
			<?php if (isset($args['geste_souvenir']) && $args['geste_souvenir'] !== 'Non'): ?>
				<?php if (isset($args['geste_souvenir_empreinte']) && $args['geste_souvenir_empreinte'] !== 'Non'): ?>
					<p style="margin: 0;">Empreinte: Oui (<?php echo $args['prix_geste_souvenir_empreinte']; ?>€ TTC)</p>
				<?php else: ?>
					<p style="margin: 0;">Empreinte: Non</p>
				<?php endif; ?>
				<?php if (isset($args['geste_souvenir_touffe']) && $args['geste_souvenir_touffe'] !== 'Non'): ?>
					<p style="margin: 0;">Touffe de poils: Oui (<?php echo $args['prix_geste_souvenir_touffe']; ?>€ TTC)</p>
				<?php else: ?>
					<p style="margin: 0;">Touffe de poils: Non</p>
				<?php endif; ?>
			<?php else: ?>
				<p style="margin: 0;">Non</p>
			<?php endif; ?>
		</td>
	</tr>

    <tr>
        <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left;">Crémation</th>
        <td style="border: 1px solid #ddd; padding: 8px;">
            <?php if($args['cremation'] == "privee"): ?>
                <p style="font-weight: 700; margin: 0;">La crémation PRIVÉE</p>
                <ul style="margin: 0; padding-left: 20px;">
                    <li>Prise en charge de l'animal décédé</li>
                    <li>Recueillement auprès de votre animal dans le salon funéraire avant sa crémation</li>
                    <li>Crémation individualisée</li>
                    <li>Remise d'un certificat de crémation</li>
                    <li>Restitution des cendres dans un tube de dispersion ou dans une urne décorative (en option).</li>
                    <li>Remise de l'urne au crématorium, en agence Esthima ou en clinique vétérinaire</li>
                </ul>
            <?php elseif($args['cremation'] == "reference"): ?>
                <p style="font-weight: 700; margin: 0;">La crémation RÉFÉRENCE</p>
                <ul style="margin: 0; padding-left: 20px;">
                    <li>Prise en charge de l'animal décédé</li>
                    <li>Crémation individualisée</li>
                    <li>Remise d'un certificat de crémation</li>
                    <li>Restitution des cendres dans un tube de dispersion ou dans une urne décorative (en option).</li>
                    <li>Remise de l'urne au crématorium, en agence Esthima ou en clinique vétérinaire</li>
                </ul>
            <?php else: ?>
                <p style="font-weight: 700; margin: 0;">La crémation PLURIELLE</p>
                <ul style="margin: 0; padding-left: 20px;">
                    <li>Prise en charge de l'animal décédé</li>
                    <li>Crémation collective avec d'autres animaux de compagnie</li>
                </ul>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left;">Total</th>
        <td style="border: 1px solid #ddd; padding: 8px;">
            <?php echo (isset($args['prix_total'])) ? $args['prix_total'] : ''; ?> € TTC
        </td>
    </tr>
</table>

<div style="margin-top: 25px; font-size: 14px;">
	* Cette simulation est fournie à titre indicatif. Elle ne prend pas en compte le lieu de prise en charge de l'animal, la disponibilité des accessoires souhaités et ne constitue donc pas un devis. Cette simulation n'a pas de valeur contractuelle. Pour un devis personnalisé, veuillez contacter nos conseillers à l’adresse suivante : <a href="mailto:contact@esthima.fr">contact@esthima.fr</a>
</div>

<div style="margin-top: 40px; text-align: center; font-size: 14px;">
	INCINERIS, une société par actions simplifiée au capital de 5.500.000 euros dont le siège social est situé 50 rue de la vague - 59650 Villeneuve d'Ascq, immatriculée au registre du commerce et des sociétés de Lille Métropole sous le numéro 805 018 959
</div>

</body>
</html>
