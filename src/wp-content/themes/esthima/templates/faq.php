<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 
?>
<?php
/*
* Template Name: FAQ
*/
get_header();
?>

<main class="main page-faq">

    <div class="wrap">
	
        <?php if ( have_posts() ) : ?>

            <?php while ( have_posts() ) : the_post(); ?>

                <div class="page-faq__content">
                    <?php the_content() ?>
                </div>
                

                <?php if( have_rows('questions_reponses') ): ?>

                    <div class="search-faq">
                        <input type="text" placeholder="Ex : Modes de paiement" />
                        <button>Rechercher</button>
                    </div>
                    <ul class="list-faq">
                        <?php while( have_rows('questions_reponses') ): the_row(); 
                            $question = get_sub_field('question');
                            $reponse = get_sub_field('reponse');
                            ?>
                            <li>
                                <div>
                                    <?php echo $question; ?>
                                </div>
                                <div>
                                    <div>
                                        <?php echo $reponse; ?>
                                    </div>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>

                <?php endif; ?>
                
            <?php endwhile; ?>

        <?php endif; ?>
        
    </div>

</main>

<?php get_footer(); ?>