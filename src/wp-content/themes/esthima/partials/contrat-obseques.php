<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php 
    if ($_SERVER['SERVER_NAME'] == 'www.esthima.fr') { 
        $orgId = "00D24000000jNFO";
        $sfUrl = "https://webto.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8&orgId=".$orgId;
    } else {
        $orgId = "00DAa000003uMCD";
        $sfUrl = "https://test.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8&orgId=".$orgId;
    }
?>
<?php if (isset($_GET['send']) && !empty($_GET['send'])) : ?>
<main class="main">
    <h3 class="h-center h-color-main">Votre demande a bien été envoyée !</h3>
</main>
<?php else: ?>
<main class="main">
    <form action="<?php echo $sfUrl; ?>" method="POST" class="rappel rappel--obseques"> 
    <input type=hidden name="oid" value="<?php echo $orgId; ?>">
    <input type=hidden name="retURL" value="<?php echo get_the_permalink() . '?send=1'; ?>">
    <input type="hidden" id="lead_source" name="lead_source" value="Web_funeral">
    
    <div class="rappel__form-title"> Vos informations :</div>
    <div class="rappel__grid">
        <div class="rappel__half">
            <select  id="salutation" name="salutation">
                <option value="">- Civilité * -</option>
                <option value="M.">M</option>
                <option value="Mlle">Mlle</option>
                <option value="Mme">Mme</option>
                <option value="Dr">Dr</option>
                <option value="Mr & Mme">Mr & Mme</option>
                <option value="Famille">Famille</option>
            </select>
        </div>
        <div class="rappel__empty"></div>
        <div class="rappel__half has-label">
            <label for="last_name">Nom *</label>
            <input  id="last_name" maxlength="80" name="last_name" size="20" type="text" />
        </div>
        <div class="rappel__half has-label">
            <label for="first_name">Prénom *</label>
            <input  id="first_name" maxlength="40" name="first_name" size="20" type="text" />
        </div>
        <div class="rappel__full has-label">
            <label for="email">Adresse e-mail *</label>
            <input  id="email" maxlength="80" name="email" size="20" type="text" />
        </div>
        <div class="rappel__full has-label">
            <label for="phone">Téléphone *</label>
            <input  id="phone" maxlength="40" name="phone" size="20" type="text" />
        </div>
    </div>
    <div class="rappel__form-title"> Votre animal :</div>
    <div class="rappel__grid">
        <div class="rappel__full has-label">
            <label for="00N0800000KQERk">Nom de l&#39;animal *</label>
            <input  id="00N0800000KQERk" maxlength="50" name="00N0800000KQERk" size="20" type="text" />
        </div>
        <div class="rappel__full">
            <select  id="00N0800000KQERh" name="00N0800000KQERh" title="Espèce de l&#39;animal">
                <option value="">- Espèce de l'animal * -</option>
                <option value="Chien">Chien</option>
                <option value="Chat">Chat</option>
                <option value="NAC">NAC</option>
            </select>
        </div>
        <div class="rappel__full has-label">
            <label for="00N0800000KQERg">Age de l&#39;animal *</label>
            <input  id="00N0800000KQERg" name="00N0800000KQERg" size="20" type="text" />
        </div>

    </div>
    L&#39;animal est pucé :<input  id="00N0800000KQERi" name="00N0800000KQERi" type="checkbox" value="1" /><br>
    L&#39;animal est tatoué :<input  id="00N0800000KQERj" name="00N0800000KQERj" type="checkbox" value="1" /><br>
    <br>
    <input id="consent" name="consent" type="checkbox" value="1" class="h-mr-8"/><label for="consent">
        En cochant cette case, j’autorise la société Incineris SASU à transmettre mes coordonnées à la société Mésange Prévoyance à des fins de prospection par téléphone ou par courrier électronique.
        <!-- J’accepte que mon adresse électronique soit transmise aux <a href="<?php echo the_permalink('crematoriums') ?>">"partenaires"</a> de la société Esthima à des fins de prospection commerciale par courrier électronique. -->
    </label>
    <input type="submit" name="submit">
    </form>
    <div>
        * Champs obligatoires
    </div>
</main>
<?php endif; ?>
