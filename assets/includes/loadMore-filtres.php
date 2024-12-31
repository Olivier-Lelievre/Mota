<?php

// GALERIE PHOTOS SUR LA PAGE D'ACCUEIL - LOAD MORE & FILTRES

function mota_load_photos() {
    // Vérification de sécurité
    check_ajax_referer('mota_load_photos', 'nonce');

    // Récupérer les paramètres des filtres
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $limit = 8;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : 'DESC';

    // Arguments de la requête
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => $limit,
        'offset'         => $offset,
        'orderby'        => 'date',
        'order'          => $date,
    );

    // Ajouter les filtres de taxonomie
    $tax_query = array('relation' => 'AND');

    if (!empty($category)) {
        $tax_query[] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    if (!empty($format)) {
        $tax_query[] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    // Exécuter la requête
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();

        while ($query->have_posts()) : $query->the_post();
            get_template_part('assets/parts/photo-block');
        endwhile;

        $html = ob_get_clean();

        // Calculer le nouvel offset et vérifier s'il reste des photos
        $new_offset = $offset + $limit;
        $no_more_photos = $query->found_posts <= $new_offset;

        wp_send_json_success([
            'html'           => $html,
            'new_offset'     => $new_offset,
            'no_more_photos' => $no_more_photos,
        ]);
    } else {
        wp_send_json_error('Aucune photo trouvée.');
    }

    wp_die();
}

add_action('wp_ajax_mota_load_photos', 'mota_load_photos');
add_action('wp_ajax_nopriv_mota_load_photos', 'mota_load_photos');