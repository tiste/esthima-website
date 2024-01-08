<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 
/*
* Template Name: Newsletter
*/
get_header();

$email = (isset($_GET['email']) && !empty(isset($_GET['email'])) ) ? trim($_GET['email']) : '';

?>
<script>
    window.newsletteremail = "<?php echo $email; ?>" 
</script>

<main class="main main-content">
    <div class="newsletter__container">
        <h1><?php echo get_the_title(); ?></h1>
        <div class="newsletter__subtitle">
            <?php echo get_the_content(); ?>
        </div>
        <div class="newsletter__form">
        <div id="formContainer_5YU6vg9mriesxZ8"></div><script src="https://public.message-business.com/Javascript/form/MB_Form_JsApp.js?v=5YU6vg9mriesxZ8"></script><script>var MB_Form_JsApp = new MB_Form_JsApp();MB_Form_JsApp.ContainerId = "formContainer_5YU6vg9mriesxZ8";MB_Form_JsApp.AccountId = "56460";MB_Form_JsApp.OperationId = "60"; MB_Form_JsApp.OperationType = "form"; MB_Form_JsApp.Init();
        setTimeout(function(){
           jQuery('#formItem-mbtext-email').val(window.newsletteremail)
           jQuery('#formItem-mbtext-email').parents('.formText').addClass('formText-written')
        }, 500)
        </script>
        </div>
    </div>
</main>




<?php get_footer(); ?>