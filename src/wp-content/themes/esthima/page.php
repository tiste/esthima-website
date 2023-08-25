<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	get_header();
?>

<main class="main">

	<div class="wrap">
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php the_content() ?>
				
			<?php endwhile; ?>

		<?php endif; ?>
	</div>

</main>

<?php get_footer(); ?>
