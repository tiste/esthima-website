<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>


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