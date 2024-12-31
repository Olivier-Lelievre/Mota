<?php
            // Récupérer les images du CPT 'photo'
            $image = get_field('image'); 
            if ($image) : ?>
                <div>
                    <img class="imageBlockPhoto" src="<?php echo esc_url($image['sizes']['large']); ?>"
                        alt="<?php echo esc_attr($image['alt']); ?>">
                </div>
            <?php endif; ?>



