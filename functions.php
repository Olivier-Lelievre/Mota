<?php 

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );



function nmota_register_assets() {
    
    // Déclarer jQuery
    wp_enqueue_script('jquery' );
    
    // Déclarer le JS
	wp_enqueue_script( 'nmota', get_template_directory_uri() . '/assets/js/script.js', array( 'jquery' ), '1.0', true);
    
    // Déclarer le fichier style.css à la racine du thème
    wp_enqueue_style( 'nmota-style', get_stylesheet_uri(), array(), '1.0');
  	
    // Déclarer le fichier CSS à un autre emplacement
    wp_enqueue_style( 'nmota-theme', get_template_directory_uri() . '/assets/css/theme.css', array(), '1.0');
}
add_action( 'wp_enqueue_scripts', 'nmota_register_assets' );



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



// création des CPT
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