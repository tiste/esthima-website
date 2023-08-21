<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Template Name: Example
*/

get_header();
?>

<main class="main">

  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>

      <h1 class="entry-title"><?php the_title() ?></h1>

      <h2>Template Example</h2>
      
      <?php the_content() ?>
      
    <?php endwhile; ?>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
