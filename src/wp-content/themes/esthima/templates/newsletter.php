<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 
/*
* Template Name: Newsletter
*/
get_header();

$email = (isset($_GET['email']) && !empty(isset($_GET['email'])) ) ? trim($_GET['email']) : '';

?>

<main class="main main-content">
    <div class="newsletter__container">
        <h1><?php echo get_the_title(); ?></h1>
        <div class="newsletter__subtitle">
            <?php echo get_the_content(); ?>
        </div>
        <div class="newsletter__form">
           <form action="">
                <select name="civilite">
                    <option value="1">Mme</option>
                    <option value="2">M.</option>
                    <option value="3">Ne se prononce pas</option>
                </select>
                <input type="text" name="nom" placeholder="nom">
                <input type="text" name="prenom" placeholder="prenom">
                <input type="email" name="email" placeholder="email" value="<?php echo $email; ?>">
                <select name="espece">
                    <option value="1">Espèce de votre animal</option>
                    <option value="2">Chien</option>
                    <option value="3">Chat</option>
                    <option value="4">NAC</option>
                </select>
                <select name="age">
                    <option value="1">Âge de votre animal</option>
                    <option value="2">1</option>
                    <option value="3">2</option>
                    <option value="4">3</option>
                    <option value="5">4</option>
                    <option value="6">5</option>
                    <option value="7">6</option>
                    <option value="8">7</option>
                    <option value="9">8</option>
                    <option value="10">9</option>
                    <option value="11">10</option>
                    <option value="12">11</option>
                    <option value="13">12</option>
                    <option value="14">13</option>
                    <option value="15">14</option>
                    <option value="16">15</option>
                    <option value="17">16</option>
                    <option value="18">17</option>
                    <option value="19">18</option>
                    <option value="20">19</option>
                    <option value="21">20</option>
                    <option value="22">21</option>
                    <option value="23">22</option>
                    <option value="24">23</option>
                    <option value="25">24</option>
                    <option value="26">25</option>
                    <option value="27">26</option>
                    <option value="28">27</option>
                    <option value="29">28</option>
                    <option value="30">29</option>
                    <option value="31">30</option>
                </select>
                <label for="accord">
                    <input type="checkbox" id="accord" name="accord">&nbsp;En m’inscrivant à la newsletter, je consens à recevoir des offres marketing sur mon adresse mail. Vous pourrez vous désabonner à tout moment en cliquant sur le lien figurant en bas du mail.
                </label>
           </form>
        </div>
    </div>
</main>

<?php get_footer(); ?>