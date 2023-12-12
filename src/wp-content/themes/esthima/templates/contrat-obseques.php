<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 

/*
* Template Name: Contrat obseques
*/
get_header();

$orgId = "00D24000000jNFO";
?>


<main class="main main-content">

    <form action="https://webto.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8&orgId=<?php echo $orgId; ?>" method="POST">

    <input type=hidden name="oid" value="<?php echo $orgId; ?>">
    <input type=hidden name="retURL" value="<?php echo home_url('callback')?>">

    <label for="salutation">Civilité</label><select  id="salutation" name="salutation"><option value="">- Aucun -</option><option value="M.">M</option>
    <option value="Mlle">Mlle</option>
    <option value="Mme">Mme</option>
    <option value="Dr">Dr</option>
    <option value="Mr &amp; Mme">Mr &amp; Mme</option>
    <option value="Famille">Famille</option>
    </select><br>

    <label for="last_name">Nom</label><input  id="last_name" maxlength="80" name="last_name" size="20" type="text" /><br>

    <label for="first_name">Prénom</label><input  id="first_name" maxlength="40" name="first_name" size="20" type="text" /><br>

    <label for="email">Adresse e-mail</label><input  id="email" maxlength="80" name="email" size="20" type="text" /><br>

    <label for="phone">Téléphone</label><input  id="phone" maxlength="40" name="phone" size="20" type="text" /><br>

    Nom de l&#39;animal :<input  id="00N0800000KQERk" maxlength="50" name="00N0800000KQERk" size="20" type="text" /><br>

    Espèce de l&#39;animal :<select  id="00N0800000KQERh" name="00N0800000KQERh" title="Espèce de l&#39;animal"><option value="">- Aucun -</option><option value="Chien">Chien</option>
    <option value="Chat">Chat</option>
    <option value="NAC">NAC</option>
    </select><br>

    Age de l&#39;animal :<input  id="00N0800000KQERg" name="00N0800000KQERg" size="20" type="text" /><br>

    L&#39;animal est pucé :<input  id="00N0800000KQERi" name="00N0800000KQERi" type="checkbox" value="1" /><br>

    L&#39;animal est tatoué :<input  id="00N0800000KQERj" name="00N0800000KQERj" type="checkbox" value="1" /><br>

    <input type="submit" name="submit">

    </form>

</main>


<?php get_footer(); ?>
