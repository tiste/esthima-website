<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 

/*
* Template Name: Wishlist
*/

if (!is_admin()) {
    if (is_user_logged_in()) {
        wp_redirect( home_url() );
        exit;
    }
}

get_header('shop');
?>

<main class="main main-content">
    <div class="wishlist__body">
        <?php if(strpos($_SERVER['REQUEST_URI'],'/search') !== false) : ?>
            <h1>Recherche une <span>liste de souhaits</span></h1>
        <?php else : ?>
            <h1>Liste de <span>souhaits</span></h1>
        <?php endif; ?>
        <?php echo do_shortcode('[yith_wcwl_wishlist]'); ?>
    </div>
</main>


<?php get_footer('shop'); ?>