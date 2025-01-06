<?php
// GALERIE PHOTOS SUR LA PAGE D'ACCUEIL - CHARGEMENT SUPPLÉMENTAIRE & FILTRES
// Fonction pour charger des photos via AJAX
function mota_load_photos() {
    // Vérifie la validité du nonce pour des raisons de sécurité
    check_ajax_referer('mota_load_photos', 'nonce');

    // Récupère les paramètres envoyés par la requête AJAX
    // 'offset' : combien de photos ont déjà été chargées (début de l'affichage)
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    // Limite du nombre de photos à charger par requête (pagination)
    $limit = 8;

    // 'category' : filtre basé sur la catégorie sélectionnée
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    // 'format' : filtre basé sur le format sélectionné
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    // 'date' : ordre de tri par date (croissant ou décroissant)
    $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : 'DESC';

    // Prépare les arguments pour la requête WordPress
    $args = array(
        'post_type'      => 'photo',            // Type de contenu à récupérer : ici des photos
        'posts_per_page' => $limit,            // Nombre maximum de photos par requête
        'offset'         => $offset,           // Décalage pour la pagination
        'orderby'        => 'date',            // Tri basé sur la date de publication
        'order'          => $date,             // Ordre du tri (ASC ou DESC)
    );

    // Prépare les filtres de taxonomie (catégorie et format)
    $tax_query = array('relation' => 'AND'); // Relation entre les filtres (ET logique)

    // Filtre sur la catégorie, si spécifiée
    if (!empty($category)) {
        $tax_query[] = array(
            'taxonomy' => 'categorie', // Taxonomie personnalisée "categorie"
            'field'    => 'slug',      // Recherche par slug (identifiant unique de la catégorie)
            'terms'    => $category,   // Valeur sélectionnée
        );
    }

    // Filtre sur le format, si spécifié
    if (!empty($format)) {
        $tax_query[] = array(
            'taxonomy' => 'format', // Taxonomie personnalisée "format"
            'field'    => 'slug',  // Recherche par slug
            'terms'    => $format, // Valeur sélectionnée
        );
    }

    // Ajoute les filtres dans les arguments si nécessaire
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    // Exécute la requête avec les arguments définis
    $query = new WP_Query($args);

    // Vérifie s'il y a des résultats
    if ($query->have_posts()) {
        ob_start(); // Démarre la mise en mémoire tampon pour capturer la sortie HTML

        // Parcourt chaque photo trouvée et affiche un bloc HTML spécifique
        while ($query->have_posts()) : $query->the_post();
            get_template_part('assets/parts/photo-block'); // Inclut un template pour chaque photo
        endwhile;

        $html = ob_get_clean(); // Récupère le HTML généré et arrête la mise en mémoire tampon

        // Calcule le nouvel offset pour la prochaine requête
        $new_offset = $offset + $limit;
        // Vérifie s'il reste des photos à charger ou si tout est déjà affiché
        $no_more_photos = $query->found_posts <= $new_offset;

        // Envoie une réponse JSON avec les résultats et l'état de la pagination
        wp_send_json_success([
            'html'           => $html,           // Contenu HTML généré
            'new_offset'     => $new_offset,     // Nouvel offset pour la prochaine requête
            'no_more_photos' => $no_more_photos, // Indique s'il reste des photos
        ]);
    } else {
        // Envoie une réponse d'erreur si aucune photo n'est trouvée
        wp_send_json_error('Aucune photo trouvée.');
    }

    // Termine le script et empêche toute sortie supplémentaire
    // Cela garantit que les réponses JSON ne sont pas corrompues par des données inattendues.
    wp_die(); 
}

// Enregistre la fonction pour les requêtes AJAX connectées (utilisateurs authentifiés)
add_action('wp_ajax_mota_load_photos', 'mota_load_photos');
// Enregistre la fonction pour les requêtes AJAX déconnectées (visiteurs anonymes)
add_action('wp_ajax_nopriv_mota_load_photos', 'mota_load_photos');

?>