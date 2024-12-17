<?php get_header(); ?>
  <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

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
                <?php if (get_field('image')) : ?>
                <img class="contentImage" src="<?php echo esc_url(get_field('image')['url']); ?>" alt="<?php echo esc_attr(get_field('image')['alt']); ?>">
                <?php endif; ?>
            </div>
        </div>
        <div class="photoContent02">
            <div class="photoContent02-contact">
                <p class="photosdescribe">Cette photo vous intéresse ?</p>
                <button>Contact</button>
            </div>
            <div class="photoContent02-nav">
                <!-- navigation prev/next -->
                <?php the_post_navigation( array(
                    'prev_text' => __( '←' ),
                    'next_text' => __( '→' ),
                    'screen_reader_text' => __( 'Post navigation' ),
                    'aria_label' => __( 'Posts' )
                ) ); ?>
            </div>
        </div>
    </div>
    <div class="photoRelated">
        <p>Vous aimerez aussi</p>
    </div>
</main>

  <?php endwhile; endif; ?>
<?php get_footer(); ?>