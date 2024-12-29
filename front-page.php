<?php get_header(); ?>

<!-- Hero & image aléatoire -->

<div class="zoneHero">
    <div class="textHero">
        <p>PHOTOGRAPHE EVENT</p>
    </div>
    <?php echo do_shortcode('[my_random_photo]'); ?>
</div>


<!-- Filtres -->

<div class="filters-wrapper">
    <div>
        <!-- Filtre Catégories -->
        <select id="category-filter" class="category-select" aria-label="Filtrer par catégorie">
            <option value="">CATÉGORIES</option>
            <?php
            // Afficher les catégories disponibles
            $categories = get_terms(array(
                'taxonomy' => 'categorie', // Taxonomie des catégories
            ));
            foreach ($categories as $category) :
                echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
            endforeach;
            ?>
        </select>

        <!-- Filtre Formats -->
        <select id="format-filter" class="format-select" aria-label="Filtrer par format">
            <option value="">FORMATS</option>
            <?php
            // Afficher les catégories disponibles
            $formats = get_terms(array(
                'taxonomy' => 'format', // Taxonomie des catégories
            ));
            foreach ($formats as $format) :
                echo '<option value="' . esc_attr($format->slug) . '">' . esc_html($format->name) . '</option>';
            endforeach;
            ?>
        </select>
    </div>

    <!-- Filtre Trier par date -->
    <select name="date-sort" id="date-filter" aria-label="Trier par date">
        <option value="ALL">TRIER PAR</option>
        <option value="DESC">à partir des plus récentes</option>
        <option value="ASC">à partir des plus anciennes</option>
    </select>
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
            
            // 4. On importe le fichier photo-block.php pour afficher une photo
            get_template_part( 'assets/parts/photo-block' );

        endwhile;
        endif;

        // 4. On réinitialise à la requête principale (important)
        wp_reset_postdata(); ?>
    </div>
</div>

<!-- bouton Load more -->
<div class="load-more-photos">
    <button
        class="bt-load-more-photos"
        data-offset="8"
        data-nonce="<?php echo wp_create_nonce('mota_load_photos'); ?>"
        data-action="mota_load_photos"
        data-ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>"
    >Charger plus</button>
</div>



<?php get_footer();