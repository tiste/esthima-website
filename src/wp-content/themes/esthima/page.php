<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	get_header();
?>

<main class="main main-content main-content--alt">

	<div class="wrap wrap--lg">
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<div class="the-content">
					<?php the_content() ?>
				</div>
				
			<?php endwhile; ?>

		<?php endif; ?>
	</div>

</main>

<?php get_footer(); ?>
