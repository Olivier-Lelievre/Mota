jQuery(document).ready(function ($) {
    // Initialisation sur le select avec ID 'category-filter'
    $('#category-filter').select2({
        placeholder: "CATÉGORIES", // Texte par défaut
        minimumResultsForSearch: Infinity, // Désactive la barre de recherche
        allowClear: true, // Croix pour effacer le champ
        width: '100%', // Ajuster à la largeur du parent
    });
    $('#format-filter').select2({
        placeholder: "FORMATS", // Texte par défaut
        minimumResultsForSearch: Infinity, // Désactive la barre de recherche
        allowClear: true, // Croix pour effacer le champ
        width: '100%', // Ajuster à la largeur du parent
    });
    $('#date-filter').select2({
        placeholder: "TRIER", // Texte par défaut
        minimumResultsForSearch: Infinity, // Désactive la barre de recherche
        width: '100%', // Ajuster à la largeur du parent
    });
});