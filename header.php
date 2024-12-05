<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header class="wrapper-header">
    <a href="<?php echo home_url( '/' ); ?>">
      <img class="logo-mota" src="<?php echo get_template_directory_uri(); ?>/assets/img/Logo-Nathalie-Mota.svg" alt="Logo Nathalie Mota photographe">
    </a> 

    <nav role="navigation" aria-label="<?php esc_html_e( 'Menu principal', 'text-domain' ); ?>">
      <button type="button" aria-expanded="false" aria-controls="primary-menu" class="menu-toggle">
          <?php esc_html_e( 'Menu', 'text-domain' ); ?>
      </button>
      <?php
        wp_nav_menu([
            'theme_location' => 'main-menu',
            'container'      => false,
            'menu_id'        => 'primary-menu',
        ]);
      ?>
    </nav>
</header>

<?php wp_body_open(); ?>