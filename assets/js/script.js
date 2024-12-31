/** MENU BURGER **/

const menuMobile = document.querySelector('header nav');
const buttonMobile = document.querySelector('.button-mobile');

buttonMobile.addEventListener('click', () => {
  menuMobile.classList.toggle('openMenu');
  buttonMobile.classList.toggle('crossBurger');
});




/** MODALE CONTACT **/

const modalContact = document.querySelector('#myModal');
const menuButtonsContact = document.querySelectorAll('.menu-item-25, .buttonSingleContact');

// Fonction pour ouvrir/fermer la modale et fermer le menu burger
const toggleModal = () => {
  modalContact.classList.toggle('openModal');
  /** fermer le menu burger **/
  menuMobile.classList.remove('openMenu');
  buttonMobile.classList.remove('crossBurger');
};

// Ajouter un gestionnaire d'événements à chaque élément
menuButtonsContact.forEach(button => {
  button.addEventListener('click', toggleModal);
});

/** fermeture de la modale - Clic en dehors **/
window.onclick = function(event) {
  if (event.target == modalContact) {
    modalContact.classList.remove('openModal');
    modalContact.classList.remove('openMenu');
  }
}




// Champ RÉF. PHOTO prérempli (voir functions.php)

jQuery(document).ready(function($) {
  $(".buttonSingleContact").on('click', function() {
      const referenceValue = acfData.reference;
      // Mettre à jour le champ de formulaire avec la valeur du champ ACF
      $("#refPhoto-CF7").val(referenceValue);
  });
}); 