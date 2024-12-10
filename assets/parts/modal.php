<div id="myModal" class="modal">
    <div class="modal-content">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Contacts-modal.png" alt="Contact">
        <?php
		// On insère le formulaire de contact 
		echo do_shortcode('[contact-form-7 id="37f348a" title="Formulaire de contact"]');
		?>
    </div>
</div>





