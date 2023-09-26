<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 

/*
* Template Name: Wishlist
*/
get_header('shop');
?>

<main class="main main-content">
    <div class="wishlist__body">
        <?php echo do_shortcode('[yith_wcwl_wishlist]'); ?>
    </div>
</main>


<?php get_footer('shop'); ?>