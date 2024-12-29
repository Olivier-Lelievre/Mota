(function ($) {
    $(document).ready(function () {

        // Chargement des photos en Ajax
        $('.bt-load-more-photos').click(function (e) {

            // Empêcher l'envoi classique (pas de rchargement de la page)
            e.preventDefault();

            // Bouton et galerie
            const button = $(this);
            const gallery = $('.image-gallery');

            // Récupération des données
            const ajaxurl = button.data('ajaxurl');
            const data = {
                action: button.data('action'),
                nonce: button.data('nonce'),
                offset: button.data('offset'), // L'offset actuel
            }

            // Envoyer la requête AJAX
            fetch(ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Cache-Control': 'no-cache',
                },
                body: new URLSearchParams(data),
            })

            
            // La suite du script sera lancé quand le serveur aura répondu -> HOOK dans functions.php
            .then(response => response.json())
            .then(body => {

                // Vérifie la réponse renvoyée par le serveur (succès ou erreur)
                if (!body.success) {
                    alert('Erreur : ' + body.data); // body.data : contient un message d'erreur spécifique envoyé par le serveur via la fonction wp_send_json_error() dans WordPress
                    return;
                }

                // Ajouter les nouvelles photos
                gallery.append(body.data.html);

                // Mettre à jour l'offset
                button.data('offset', body.data.new_offset);

                // Cacher le bouton si plus de photos
                if (body.data.no_more_photos) {
                    button.hide();
                }
            })
            
        });
    });
})(jQuery);
