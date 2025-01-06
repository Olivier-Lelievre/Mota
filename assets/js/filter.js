(function ($) {
    // Attendre que le document soit prêt
    $(document).ready(function () {
        // Sélection des éléments importants
        const gallery = $('.image-gallery'); // Conteneur de la galerie d'images, utilisé pour afficher dynamiquement les photos chargées
        const button = $('.bt-load-more-photos'); // Bouton "Charger plus"
        
        // Initialisation des variables
        let offset = 8; // Nombre initial d'images chargées
        let filters = {
            category: '', // Stocke le filtre de catégorie sélectionné pour la requête AJAX
            format: '',   // Stocke le filtre de format sélectionné pour la requête AJAX
            date: 'DESC', // Stocke l'ordre de tri par date pour la requête AJAX (croissant ou décroissant)
        };

        // Gestion des filtres (changement dans les sélections)
        $('.filters-wrapper select').change(function () {
            // Met à jour les filtres sélectionnés
            filters.category = $('#category-filter').val();
            filters.format = $('#format-filter').val();
            filters.date = $('#date-filter').val();

            // Réinitialise la galerie et l'offset
            offset = 0;
            gallery.empty(); // Vide la galerie actuelle
            button.data('offset', 0); // Réinitialise l'offset sur le bouton

            // Recharge les photos avec les nouveaux filtres
            loadPhotos(true);
        });

        // Gestion du clic sur le bouton "Charger plus"
        button.click(function (e) {
            e.preventDefault(); // Empêche l'action par défaut du bouton
            loadPhotos(false); // Charge plus d'images sans réinitialiser
        });

        // Fonction pour charger des photos via AJAX
        function loadPhotos(reset = false) {
            // Récupération des données dynamiques depuis le bouton
            const ajaxurl = button.data('ajaxurl'); // URL pour la requête AJAX
            const data = {
                action: button.data('action'), // Action WordPress définie dans PHP
                nonce: button.data('nonce'),   // Jeton de sécurité
                offset: reset ? 0 : offset,   // Offset selon réinitialisation ou non
                category: filters.category,   // Filtres de catégorie
                format: filters.format,       // Filtres de format
                date: filters.date,           // Tri par date
            };

            // Envoi de la requête AJAX avec fetch API pour récupérer des photos
            fetch(ajaxurl, { // Envoie une requête AJAX au serveur pour récupérer des photos
                method: 'POST', // Méthode HTTP POST pour l'envoi de données
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded', // Type de contenu
                },
                body: new URLSearchParams(data), // Encodage des données au format URL
            })
                .then(response => response.json()) // Convertit la réponse en JSON
                .then(body => {
                    // Gestion des erreurs renvoyées par le serveur, par exemple lorsque la requête échoue
                    if (!body.success) {
                        alert('Erreur : ' + body.data); // Affiche l'erreur
                        return;
                    }

                    // Ajoute les nouvelles photos dans la galerie existante
                    gallery.append(body.data.html); // Insère le contenu HTML des nouvelles photos dans la galerie

                    // Met à jour l'offset avec la nouvelle valeur
                    offset = body.data.new_offset;
                    button.data('offset', offset);

                    // Affiche ou cache le bouton selon s'il reste des photos
                    if (body.data.no_more_photos) {
                        button.hide(); // Cache le bouton si plus de photos
                    } else {
                        button.show(); // Affiche le bouton sinon
                    }
                });
        }
    });
})(jQuery);
