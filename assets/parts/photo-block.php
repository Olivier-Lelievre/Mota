<?php
$image = get_field('image'); 
$reference = get_field('reference');
$categories = get_the_terms(get_the_ID(), 'categorie');
$category = !empty($categories) ? esc_html($categories[0]->name) : 'Aucune catégorie';
$permalink = get_permalink(); // Récupère l'URL de la page individuelle

if ($image) : ?>
    <div class="photo-item" 
         data-src="<?php echo esc_url($image['sizes']['large']); ?>" 
         data-ref="<?php echo esc_attr($reference); ?>" 
         data-cat="<?php echo esc_attr($category); ?>"
         data-url="<?php echo esc_url($permalink); ?>"> <!-- Ajout de l'URL -->
        <a href="#" class="link-imageBlockPhoto">
            <img class="imageBlockPhoto" src="<?php echo esc_url($image['sizes']['large']); ?>" 
                 alt="<?php echo esc_attr($image['alt']); ?>">
        </a>

        <!-- OVERLAY -->
        <div class="overlay">
            <div class="overlayLightbox">
                <button class="bt-overlayLightbox">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Icon_fullscreen.svg" alt="afficher la photo dans la lightbox">
                </button>
            </div>
            <div class="overlaySinglePhoto">
                <button class="bt-overlaySinglePhoto">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Icon_eye.svg" alt="aller à la page de détail de la photo">
                </button>
            </div>
            <div class="overlayInfos">
                <p class="txt-lightbox-ref"><?php echo esc_attr($reference); ?></p>
                <p class="txt-lightbox-cat"><?php echo esc_attr($category); ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>
