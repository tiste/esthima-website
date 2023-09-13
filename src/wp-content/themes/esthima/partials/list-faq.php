<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php 
//OLD VERSION (ACF)
if (false) : ?>

    <?php if( have_rows('questions_reponses', 154) ): ?>

        <div class="search-faq">
            <input type="text" placeholder="Ex : Modes de paiement" />
            <button>Rechercher</button>
        </div>

        <ul class="list-faq">
            <?php while( have_rows('questions_reponses', 154) ): the_row(); 
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

<?php endif; ?>


<?php 
//NEW VERSION (CPT)
if (true) : ?>

    <?php $questions_reponses = new WP_Query( array( 'post_type' => 'faq', 'posts_per_page' => '-1' ) ); ?>

    <?php if ( $questions_reponses->have_posts() ) : ?>

        <ul class="list-faq">
            <?php while ( $questions_reponses->have_posts() ) : $questions_reponses->the_post();
                $question = get_the_title();
                $reponse = get_the_content();
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

<?php endif; ?>