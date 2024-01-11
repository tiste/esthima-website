<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php
use App\Services\Kiamo;
define('KIAMO_ENDPOINT', 'https://incineris-kiamo-labo.komeo.fr/api/v2/');
define('KIAMO_TOKEN', '083e55bde788591bbfdc6316774b24c8c37d40ce');
define('KIAMO_CALLBACK_ID', '89');
$kiamo = new Kiamo(KIAMO_ENDPOINT, KIAMO_TOKEN, KIAMO_CALLBACK_ID);

$isCompleted = false;
$emptyGender = false;
$emptyLastname = false;
$emptyFirstname = false;
$emptyTel = false;
$emptyPostcode = false;
$errorTel = false;
$errorPostcode = false;
if (isset($_POST['go'])) {
    if(
        !is_null($_POST['gender']) && !empty($_POST['gender']) &&
        !is_null($_POST['lastname']) && !empty($_POST['lastname']) &&
        !is_null($_POST['firstname']) && !empty($_POST['firstname']) &&
        !is_null($_POST['tel']) && !empty($_POST['tel']) &&
        !is_null($_POST['postalCode']) && !empty($_POST['postalCode'])
    ){
        if(
            strlen($_POST['tel'])!=10 ||
            $_POST['tel'][0] != '0' ||
            $_POST['tel'][1] != '1' || $_POST['tel'][1] != '2' || $_POST['tel'][1] != '3' || $_POST['tel'][1] != '4' || $_POST['tel'][1] != '5' || $_POST['tel'][1] != '6' || $_POST['tel'][1] != '7' || $_POST['tel'][1] != '8' || $_POST['tel'][1] != '9'
        ){
            $errorTel = true;
        }elseif(
            strlen($_POST['postalCode'])!=5
        ){
            $errorPostcode = true;
        }else{
            $isCompleted = true;
            if(!$kiamo->isRewind($_POST['tel'])){
                $request = array(
                    'gender' => $_POST['gender'],
                    'lastname' => $_POST['lastname'],
                    'firstname' => $_POST['firstname'],
                    'phone' => $_POST['tel'],
                    'postalCode' => $_POST['postalCode']
                );
                $kiamo->postRewind($request);
            }
        }
    }else{
        if(is_null($_POST['gender']) || empty($_POST['gender'])){
            $emptyGender = true;
        }
        if(is_null($_POST['lastname']) || empty($_POST['lastname'])){
            $emptyLastname = true;
        }
        if(is_null($_POST['firstname']) || empty($_POST['firstname'])){
            $emptyFirstname = true;
        }
        if(is_null($_POST['tel']) || empty($_POST['tel'])){
            $emptyTel = true;
        }
        if(is_null($_POST['postalCode']) || empty($_POST['postalCode'])){
            $emptyPostcode = true;
        }
    }
}
?>

<?php if(!$isCompleted) : ?>
<form action="" method="POST" class="rappel">
    <div class="rappel__grid">
        <div class="rappel__half">
            <select name="gender" id="gender">
                <option value="Mr">Mr</option>
                <option value="Mme">Mme</option>
            </select>
            <?php if($emptyGender) : ?>
                <div class="rappel__error">Ce champ est obligatoire</div>
            <?php endif; ?>
        </div>
        <div class="rappel__empty"></div>
        <div class="rappel__half has-label">
            <label for="lastname">Nom*</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo (isset($_POST['lastname'])) ? $_POST['lastname'] : ''; ?>">
            <?php if($emptyLastname) : ?>
                <div class="rappel__error">Ce champ est obligatoire</div>
            <?php endif; ?>
        </div>
        <div class="rappel__half has-label">
            <label for="firstname">Prénom*</label>
            <input type="text" name="firstname" id="firstname" value="<?php echo (isset($_POST['firstname'])) ? $_POST['firstname'] : ''; ?>">
            <?php if($emptyFirstname) : ?>
                <div class="rappel__error">Ce champ est obligatoire</div>
            <?php endif; ?>
        </div>
        <div class="rappel__full has-label">
            <label for="tel">Téléphone*</label>
            <input type="tel" name="tel" id="tel" maxlength="10" value="<?php echo (isset($_POST['tel'])) ? $_POST['tel'] : ''; ?>">
            <?php if($errorTel) : ?>
                <div class="rappel__error">Merci de renseigner un numéro de téléphone valide</div>
            <?php endif; ?>
            <?php if($emptyTel) : ?>
                <div class="rappel__error">Ce champ est obligatoire</div>
            <?php endif; ?>
        </div>
        <div class="rappel__full has-label">
            <label for="postalCode">Code postal*</label>
            <input type="tel" name="postalCode" id="postalCode" maxlength="5" value="<?php echo (isset($_POST['postalCode'])) ? $_POST['postalCode'] : ''; ?>">
            <?php if($errorPostcode) : ?>
                <div class="rappel__error">Merci de renseigner un code postal valide</div>
            <?php endif; ?>
            <?php if($emptyPostcode) : ?>
                <div class="rappel__error">Ce champ est obligatoire</div>
            <?php endif; ?>
        </div>
    </div>
    <input type="submit" name="go" method="post" value="Être rappelé">
</form>
<div>* Champs obligatoires</div>
<?php else : ?>
    <p class="has-text-align-center has-medium-font-size" style="font-style:normal;font-weight:600">Merci, nous allons vous recontacter dans les plus brefs délais.</p>
<?php endif; ?>