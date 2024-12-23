<?php
            // Cette partie va dans le template-parts (ici donc) et le reste (query vars, requête, boucle et réinitialisation) sur la page single-photo.php.
            // Pour la page d'accueil c'est le même template-part mais ce qui change c'est le code (query vars, requête, boucle et réinitialisation) sur le fichier front-page.php
            // Récupérer les images du CPT 'photo'
            $image = get_field('image'); 
            if ($image) : ?>
                <div>
                    <img class="imageBlockPhoto" src="<?php echo esc_url($image['sizes']['large']); ?>"
                        alt="<?php echo esc_attr($image['alt']); ?>">
                </div>
            <?php endif; ?>



