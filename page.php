<?php

get_header();

/* Start the Loop */
if (have_posts()) :
    while (have_posts()) : the_post();
        the_content(); // Affiche le contenu de la page
    endwhile;
else :
    echo '<p>Aucun contenu trouvé.</p>';
endif;

get_footer();