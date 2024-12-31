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

    // Select2
    wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
    wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), null, true);
    // Ajouter un fichier JS personnalisé pour l'initialisation
    wp_enqueue_script('custom-select2', get_template_directory_uri() . '/assets/js/custom-select2.js', array('jquery', 'select2-js'), null, true);

    // Déclarer le fichier style.css à la racine du thème
    wp_enqueue_style('nmota-theme', get_template_directory_uri() . '/assets/css/theme.css', [], '1.0');
}
add_action('wp_enqueue_scripts', 'nmota_register_assets');






// HEADER : déclarer l'emplacement du menu principal
function nmota_register_my_menu() {
    register_nav_menu( 'main-menu', __( 'Menu principal', 'text-domain' ) );
}
add_action( 'after_setup_theme', 'nmota_register_my_menu' );


// FOOTER : déclarer l'emplacement du menu du bas de page
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



// CHARGEMENT INCLUDES
include get_template_directory() . '/assets/includes/random-Hero.php';
include get_template_directory() . '/assets/includes/loadMore-filtres.php';