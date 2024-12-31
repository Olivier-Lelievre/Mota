<?php

// CHARGEMENT PHOTO EN ALÉATOIRE DANS LE HÉRO DE LA PAGE D'ACCUEIL

function my_random_photo_shortcode() {
    // 1. Préparer la variable de sortie
    $output = '';

    // 2. Configurer la WP Query
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 1, 
        'orderby' => 'rand', 
        'tax_query' => array( 
            array(
                'taxonomy' => 'format',
                'field' => 'slug',
                'terms' => 'paysage',
            ),
        ),
    );

    // 3. Exécuter la requête
    $query = new WP_Query($args);

    // 4. Vérifier s'il y a des posts
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // 5. Récupérer l'image via un champ personnalisé ACF
            $image = get_field('image'); 
            if ($image) {
                // Ajouter un conteneur avec l'image en background
                $output .= '<div class="random-photo-background" style="background-image: url(' . esc_url($image['url']) . ');"></div>';

            }
        }
        // Réinitialiser la requête
        wp_reset_postdata();
    } else {
        // Si aucun post n'est trouvé
        $output .= '<p>Aucune image trouvée.</p>';
    }

    // 6. Retourner le résultat
    return $output;
}

// Ajouter le shortcode
add_shortcode('my_random_photo', 'my_random_photo_shortcode');
// Autoriser les shortcodes dans les widgets texte
add_filter('widget_text', 'do_shortcode');