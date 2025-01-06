<?php get_header(); ?>

<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

<div class="degAfterHeader"> </div>

<main>
    <div class="photoContent">
        <div class="photoContent01">
            <div class="photoContent01-text">
                <h2><?php single_post_title(); ?></h2>
                <p>Référence : <?php the_field( 'reference' ); ?></p>
                <!-- Utilisation de get_the_terms pour récupérer la taxonomie personnalisée -->
                <p>Catégorie : <?php $categories = get_the_terms( get_the_ID(), 'categorie' );
                    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                        foreach ( $categories as $category ) {
                            echo esc_html( $category->name );
                        }
                    } else {
                        echo 'Aucune catégorie';
                    }?>
                </p>
                <!-- Utilisation de get_the_terms pour récupérer la taxonomie personnalisée -->
                <p>Format : <?php $formats = get_the_terms( get_the_ID(), 'format' );
                    if ( ! empty( $formats ) && ! is_wp_error( $formats ) ) {
                        foreach ( $formats as $format ) {
                            echo esc_html( $format->name );
                        }
                    } else {
                        echo 'Aucune catégorie';
                    }?>
                </p>
                <p>Type : <?php the_field( 'type' ); ?></p>
                <!-- Utilisation de get_the_date pour récupérer l'année -->
                <?php $dateDisplay = get_the_date('Y');
                echo '<p>Année : ' . esc_html($dateDisplay) . '</p>';
                ?>
            </div>
            <div class="photoContent01-image">
                <!-- Utilisation de get_field pour récupérer l'image -->
                <?php
                $image = get_field('image'); // Récupérer le champ ACF
                if ($image) : ?>
                    <img class="contentImage" src="<?php echo esc_url($image['sizes']['large']); ?>"
                        alt="<?php echo esc_attr($image['alt']); ?>">
                <?php endif; ?>
            </div>
        </div>
        <div class="photoContent02">
            <div class="photoContent02-contact">
                <p class="photosdescribe">Cette photo vous intéresse ?</p>
                <button class="buttonSingleContact">Contact</button>
            </div>
            <div class="photoContent02-nav">

                <?php
                // Récupérer le post précédent et suivant
                $prevPost = get_previous_post();
                $nextPost = get_next_post();
                ?>
                <nav class="navigation-wrapper" aria-label="Navigation entre posts">
                    <?php 
                    function render_navigation_item($post, $direction) {
                        if ($post) {
                            $thumbnail = get_field('image', $post->ID);
                            // opérateur ternaire pour écrire des conditions simples en une seule ligne
                            $arrow = $direction === 'prev' ? '←' : '→';
                            $ariaLabel = $direction === 'prev' ? 'précédent' : 'suivant';
                            $class = $direction === 'prev' ? 'nav-prev' : 'nav-next';
                            ?>
                            <div class="nav-item <?php echo $class; ?>">
                                <?php if (!empty($thumbnail['sizes']['thumbnail'])) : ?>
                                    <div class="preview-image">
                                        <img src="<?php echo esc_url($thumbnail['sizes']['thumbnail']); ?>"
                                            alt="<?php echo esc_attr($thumbnail['alt']); ?>">
                                    </div>
                                <?php endif; ?>
                                <a href="<?php echo get_permalink($post->ID); ?>" class="nav-arrow"
                                aria-label="Voir le post <?php echo $ariaLabel; ?> : <?php echo esc_attr(get_the_title($post->ID)); ?>">
                                    <?php echo $arrow; ?>
                                </a>
                            </div>
                            <?php
                        }
                    }

                    // Afficher le post précédent et suivant
                    render_navigation_item($prevPost, 'prev');
                    render_navigation_item($nextPost, 'next');
                    ?>
                </nav>

            </div>
        </div>
    </div>
    <div class="photoRelated">
        <h3>Vous aimerez aussi</h3>
        <div class="images-photoRelated">
            <?php
            // PHOTOS APPARENTÉES
            // Réutilisation de $categories pour les photos apparentées
            $current_photo_category_ids = array();

            if ($categories && !is_wp_error($categories)) {
                foreach ($categories as $category) {
                    $current_photo_category_ids[] = $category->term_id;
                }
            }

            $args = array(
                'post_type' => 'photo',
                'posts_per_page' => 2,
                'orderby' => 'rand',
                'tax_query' => array( // récupérer la taxonomie personnalisée 'categorie'
                    array(
                        'taxonomy' => 'categorie',
                        'field'    => 'term_id',
                        'terms'    => $current_photo_category_ids,
                    ),
                ),
            );

            // 2. On exécute la WP Query
            $my_query = new WP_Query( $args );

            // 3. On lance la boucle
            if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();

                // 4. On importe le fichier photo-block.php contenat ce qui est affiché
                get_template_part( 'assets/parts/photo-block' );
                
            endwhile;
            endif;
            // 5. On réinitialise à la requête principale (important)
            wp_reset_postdata();
            ?>
        </div>
    </div>
</main>

<?php endwhile; endif; ?>

<?php get_footer(); ?>