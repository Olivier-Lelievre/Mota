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
        <p>TOUS DROITS RÉSERVÉS</p>

        <!-- The Modal -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">x</span>
            </div>
        </div>

    </footer>
    <?php wp_footer(); ?>
</body>
</html>