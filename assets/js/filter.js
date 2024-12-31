(function ($) {
    $(document).ready(function () {
        const gallery = $('.image-gallery');
        const button = $('.bt-load-more-photos');
        let offset = 8; // Nombre initial d'images chargées
        let filters = {
            category: '',
            format: '',
            date: 'DESC',
        };

        // Mise à jour des filtres
        $('.filters-wrapper select').change(function () {
            filters.category = $('#category-filter').val();
            filters.format = $('#format-filter').val();
            filters.date = $('#date-filter').val();

            offset = 0; // Réinitialiser l'offset
            gallery.empty(); // Vider la galerie
            button.data('offset', 0); // Réinitialiser l'offset sur le bouton

            loadPhotos(true); // Recharger les photos avec les nouveaux filtres
        });

        // Bouton "Charger plus"
        button.click(function (e) {
            e.preventDefault();
            loadPhotos(false); // Charger plus sans réinitialisation
        });

        function loadPhotos(reset = false) {
            const ajaxurl = button.data('ajaxurl');
            const data = {
                action: button.data('action'),
                nonce: button.data('nonce'),
                offset: reset ? 0 : offset, // Réinitialiser ou continuer
                category: filters.category,
                format: filters.format,
                date: filters.date,
            };

            fetch(ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(data),
            })
                .then(response => response.json())
                .then(body => {
                    if (!body.success) {
                        alert('Erreur : ' + body.data);
                        return;
                    }

                    // Ajouter les nouvelles photos
                    gallery.append(body.data.html);

                    // Mettre à jour l'offset
                    offset = body.data.new_offset;
                    button.data('offset', offset);

                    // Afficher ou masquer le bouton
                    if (body.data.no_more_photos) {
                        button.hide();
                    } else {
                        button.show(); // Toujours afficher si d'autres photos existent
                    }
                });
        }
    });
})(jQuery);





