<?php 

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );





// CHARGEMENT DES SCRIPTS ET STYLES

function nmota_register_assets() {
    // Déclarer jQuery
    wp_enqueue_script('jquery');
    // Déclarer le fichier JS principal
    wp_enqueue_script('nmota', get_template_directory_uri() . '/assets/js/script.js', ['jquery'], '1.0', true);

// Champ Réf. photo prérempli : localiser les données ACF uniquement si nécessaire
    if (is_singular('photo')) {
        // Récupérer l'ID du post
        $post_id = get_the_ID();
        // Récupérer la valeur du champ personnalisé "reference" du groupe "Photographie"
        $reference = get_field('reference', $post_id);
        // Passer cette valeur à un script JavaScript
        wp_localize_script('nmota', 'acfData', [
            'reference' => $reference ? $reference : '',
        ]);
    }

// Chargement du script filter.js pour la page d'accueil
    if (is_front_page()) {
        wp_enqueue_script('mota_photos', get_template_directory_uri() . '/assets/js/filter.js', ['jquery'], '1.0', true);
    }

// Déclarer le fichier style.css à la racine du thème
    wp_enqueue_style('nmota-theme', get_template_directory_uri() . '/assets/css/theme.css', [], '1.0');
}
add_action('wp_enqueue_scripts', 'nmota_register_assets');



// Déclarer l'emplacement du menu principal (header)
function nmota_register_my_menu() {
    register_nav_menu( 'main-menu', __( 'Menu principal', 'text-domain' ) );
}
add_action( 'after_setup_theme', 'nmota_register_my_menu' );

// Déclarer l'emplacement du menu du bas de page (footer)
function nmota_register_footer_menu() {
    register_nav_menu( 'footer-menu', __( 'Bas de page', 'text-domain' ) );
}
add_action( 'after_setup_theme', 'nmota_register_footer_menu' );





// CRÉATION DU CPT 'PHOTO'

// !!!!! Ne pas oublier d'enregistrer les modifications dans le menu Réglages/Permaliens après la création d'un CPT !!!!!
function nmota_register_post_types() {
    // création du CPT Photo
    $labels = array(
        'name' => 'Photo', 
        'all_items' => 'Toutes les photos',  // affiché dans le sous menu
        'singular_name' => 'Photo',
        'add_new_item' => 'Ajouter une photo',
        'edit_item' => 'Modifier la photo',
        'menu_name' => 'Photos' // nom qui apparaît dans le menu
    );
	$args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_rest' => false,
        'has_archive' => true,
        'supports' => array( 'title'),
        'menu_position' => 5, 
        'menu_icon' => 'dashicons-format-gallery',
	);
	register_post_type( 'photo', $args ); // !!!!! SLUG !!!!! Une fois le CPT enregistré, ne jamais changer ce nom 'photo' (slug) !!!!!
}
add_action( 'init', 'nmota_register_post_types' );






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





// GALERIE PHOTOS SUR LA PAGE D'ACCUEIL - LOAD MORE

function mota_load_photos() {
    // Vérification de sécurité
    check_ajax_referer('mota_load_photos', 'nonce');

    // Paramètres d'offset
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $limit = 8; // Nombre de photos à charger

    // Arguments de la WP_Query
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => $limit,
        'offset'         => $offset,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start(); // Démarrer le buffer de sortie (stocké temporairement dans une mémoire tampon (buffer) au lieu d’être directement envoyé au navigateur)

        while ($query->have_posts()) : $query->the_post();

            // Importer la mise en page d'une photo
            get_template_part('assets/parts/photo-block');

        endwhile;

        $html = ob_get_clean(); // Récupérer le contenu HTML généré dynamiquement (buffer) et le stocker dans une variable ($html)

        // Calculer le nouvel offset
        $new_offset = $offset + $limit;

        // Vérifier s'il reste des photos
        $no_more_photos = $query->found_posts <= $new_offset;

        // Réponse JSON (Envoie de ce contenu au format JSON pour que JavaScript puisse l’ajouter dynamiquement sur la page)
        wp_send_json_success([
            'html'           => $html,
            'new_offset'     => $new_offset,
            'no_more_photos' => $no_more_photos,
        ]);
    } else {
        wp_send_json_error('Aucune photo trouvée.');
    }

    wp_die(); // Fin de la requête AJAX
}

add_action( 'wp_ajax_mota_load_photos', 'mota_load_photos' );
add_action( 'wp_ajax_nopriv_mota_load_photos', 'mota_load_photos' );