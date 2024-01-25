<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    body, html {
        font-family: 'Urbanist';
        color: #151515;
    }
 
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    td b {
        color: #336699;
    }

    ul {
    }

    li {
        margin-bottom: 5px;
    }
    .title {
        font-weight: 700;
    }
</style>
</head>

<body <?php body_class(); ?>>
<div style="margin-bottom: 50px">
    <img src="<?php echo get_template_directory_uri() . '/images/configurateur/logo_esthima.png'; ?>" alt="">
</div>
<div>
    Nom: <?php echo (isset($args['nom_personne'])) ? $args['nom_personne'] : ''; ?>
    <br>
    Prénom: <?php echo (isset($args['prenom_personne'])) ? $args['prenom_personne'] : ''; ?>
    <br>
    Email: <?php echo (isset($args['email'])) ? $args['email'] : ''; ?>
    <br>
    <br>
</div>
<table>
    <tr>
        <td class="title">Espèce</td>
        <td><?php echo (isset($args['espece'])) ? $args['espece'] : ''; ?></td>
    </tr>
    <tr>
        <td class="title">Nom</td>
        <td><?php echo (isset($args['nom'])) ? $args['nom'] : ''; ?></td>
    </tr>
    <tr>
        <td class="title">Récupération des cendres</td>
        <td><?php echo (isset($args['recuperation_cendres']) && $args['recuperation_cendres']) ? 'Oui' : 'Non'; ?></td>
    </tr>
    <tr>
        <td class="title">Cérémonie d'adieu</td>
        <td><?php echo (isset($args['ceremonie_adieu'])) ? $args['ceremonie_adieu'] : ''; ?></td>
    </tr>
    <tr>
        <td class="title">Urne</td>
        <td><?php echo (isset($args['urne'])) ? $args['urne'] : ''; ?></td>
    </tr>
    <tr>
        <td class="title">Geste souvenir</td>
        <td> 
            <?php if (isset($args['geste_souvenir'])): ?>
                <?php if (isset($args['geste_souvenir_empreinte'])): ?>
                    <br>
                    Empreinte: Oui / <?php echo $args['prix_geste_souvenir_empreinte']; ?> €
                <?php endif; ?> 
                <?php if (isset($args['geste_souvenir_empreinte'])): ?>
                    <br>
                    Touffe de poils: Oui / <?php echo $args['prix_geste_souvenir_touffe']; ?> € 
                <?php endif; ?> 
            <?php endif; ?> 
        </td>
    </tr>
    <tr>
        <td class="title">Crémation</td>
        <td>
            <?php if($args['cremation'] == "privee"): ?>
                <span style="font-weight: 700;">La crémation PRIVÉE</span>
                <ul>
                    <li>Prise en charge de l'animal décédé</li>
                    <li>Recueillement auprès de votre animal dans le salon funéraire avant sa crémation</li>
                    <li>Crémation individualisée</li>
                    <li>Remise d'un certificat de crémation</li>
                    <li>Restitution des cendres dans un tube de dispersion ou dans une urne décorative (en option).</li>
                    <li>Remise de l'urne au crématorium, en agence Esthima ou en clinique vétérinaire</li>
                </ul>
                <?php elseif($args['cremation'] == "reference"): ?>
                <span style="font-weight: 700;">La crémation RÉFÉRENCE</span>
                <ul>
                    <li>Prise en charge de l'animal décédé</li>
                    <li>Crémation individualisée</li>
                    <li>Remise d'un certificat de crémation</li>
                    <li>Restitution des cendres dans un tube de dispersion ou dans une urne décorative (en option).</li>
                    <li>Remise de l'urne au crématorium, en agence Esthima ou en clinique vétérinaire</li>
                </ul>
                <?php else: ?>
                <span style="font-weight: 700;">La crémation PLURIELLE</span>
                <ul>
                    <li>Prise en charge de l'animal décédé</li>
                    <li>Crémation collective avec d'autres animaux de compagnie</li>
                </ul>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td class="title">Total</td>
        <td><?php echo (isset($args['prix_total'])) ? $args['prix_total'] : ''; ?> €</td>
    </tr>

</table>

</body>
</html>