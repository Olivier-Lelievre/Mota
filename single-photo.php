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
                <?php
                $image = get_field('image'); // Récupérer le champ ACF
                if ($image) : ?>
                    <img class="contentImage" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
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
    <!-- Navigation - post précedent -->
    <div class="nav-item nav-prev">
        <?php if ($prevPost) : ?>
            <?php 
            $prevThumbnail = get_field('image', $prevPost->ID);
            if (!empty($prevThumbnail['url'])) : ?>
                <div class="preview-image">
                    <img src="<?php echo esc_url($prevThumbnail['url']); ?>" 
                         alt="<?php echo esc_attr($prevThumbnail['alt']); ?>">
                </div>
            <?php endif; ?>
            <a href="<?php echo get_permalink($prevPost->ID); ?>" class="nav-arrow" 
               aria-label="Voir le post précédent : <?php echo esc_attr(get_the_title($prevPost->ID)); ?>">
                ←
            </a>
        <?php endif; ?>
    </div>
    <!-- Navigation - post suivant -->
    <div class="nav-item nav-next">
        <?php if ($nextPost) : ?>
            <?php 
            $nextThumbnail = get_field('image', $nextPost->ID);
            if (!empty($nextThumbnail['url'])) : ?>
                <div class="preview-image">
                    <img src="<?php echo esc_url($nextThumbnail['url']); ?>" 
                         alt="<?php echo esc_attr($nextThumbnail['alt']); ?>">
                </div>
            <?php endif; ?>
            <a href="<?php echo get_permalink($nextPost->ID); ?>" class="nav-arrow" 
               aria-label="Voir le post suivant : <?php echo esc_attr(get_the_title($nextPost->ID)); ?>">
                →
            </a>
        <?php endif; ?>
    </div>
</nav>


















            </div>
        </div>
    </div>
    <div class="photoRelated">
        <p>Vous aimerez aussi</p>
    </div>
</main>

  <?php endwhile; endif; ?>
<?php get_footer(); ?>