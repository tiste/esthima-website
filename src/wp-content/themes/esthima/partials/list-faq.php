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

    <?php if ( $questions_reponses->have_posts() ) : $currentFAQ = 0; ?>

        <?php
            $cats = get_terms(array(
                'taxonomy' => 'faq_cat',
                'hide_empty' => false
            ))
        ?>

        <?php if(!is_null($cats) && !empty($cats) && is_array($cats)) : ?>
            <div class="cats-faq">
                <?php foreach($cats as $c) : ?>
                    <div class="cats-faq__cat" data-slug="<?php echo $c->slug; ?>">
                        <?php echo $c->name; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <select class="cats-faq-mob">
                <option value="all">Toutes les FAQs</option>
                <?php foreach($cats as $c) : ?>
                    <option value="<?php echo $c->slug; ?>"><?php echo $c->name; ?></option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <ul class="list-faq">
            <?php while ( $questions_reponses->have_posts() ) : $questions_reponses->the_post();
                $question = get_the_title();
                $reponse = get_the_content();
                $terms = get_the_terms( get_the_ID(), 'faq_cat' );
                $terms = join('**', wp_list_pluck( $terms , 'slug') );
                ?>
                <li class="list-faq__item <?php echo ($currentFAQ==0) ? 'list-faq__item-open' : 'list-faq__item-closed'; ?>" data-cats="*<?php echo $terms; ?>*">
                    <div class="list-faq__item__question">
                        <?php echo $question; ?>
                    </div>
                    <div class="list-faq__item__answer">
                        <div class="list-faq__item__answer__content">
                            <?php echo $reponse; ?>
                        </div>
                    </div>
                </li>
            <?php $currentFAQ++; endwhile; ?>
        </ul>

    <?php endif; ?>

<?php endif; ?>