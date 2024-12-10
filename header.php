<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header>
    <div>
      <a href="<?php echo home_url( '/' ); ?>">
        <img class="logo-mota" src="<?php echo get_template_directory_uri(); ?>/assets/img/Logo-Nathalie-Mota.svg" alt="Logo Nathalie Mota photographe">
      </a> 
      <button class="button-mobile">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
      </button>
    </div>
    <nav role="navigation" aria-label="<?php esc_html_e( 'Menu principal', 'text-domain' ); ?>">
      <?php wp_nav_menu([ 'theme_location' => 'main-menu', 'container' => false, 'menu_id' => 'primary-menu']);?>
    </nav>
</header>

<?php wp_body_open(); ?>