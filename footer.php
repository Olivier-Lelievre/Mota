    <footer class="site__footer">
        <?php 
	        wp_nav_menu( 
            array( 
                'theme_location' => 'footer-menu', 
                'container' => 'ul', // afin d'éviter d'avoir une div autour 
                'menu_class' => 'site__footer__menu', // ma classe personnalisée 
            ) 
        ); 
        ?>
        <p class="textFooter">TOUS DROITS RÉSERVÉS</p>
        <?php get_template_part( 'assets/parts/modal' ); ?>
        <?php get_template_part( 'assets/parts/lightbox' ); ?>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>