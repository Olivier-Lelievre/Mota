<?php get_header(); ?>

<!-- Hero & image aléatoire -->

<div class="zoneHero">
    <div class="textHero">
        <p>PHOTOGRAPHE EVENT</p>
    </div>
    <?php echo do_shortcode('[my_random_photo]'); ?>
</div>


<!-- Galerie d'images -->

<div class="image-gallery-wrapper">
    <div class="image-gallery">
        <?php 
        // 1. On définit les arguments pour définir ce que l'on souhaite récupérer
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 8,
        );


        // 2. On exécute la WP Query
        $my_query = new WP_Query( $args );

        // 3. On lance la boucle !
        if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();
            
            // 4. On importe le fichier photo-block.php contenat ce qui est affiché
            get_template_part( 'assets/parts/photo-block' );

        endwhile;
        endif;

        // 4. On réinitialise à la requête principale (important)
        wp_reset_postdata(); ?>
    </div>
</div>

<?php get_footer();