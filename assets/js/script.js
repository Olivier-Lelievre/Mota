/** MENU BURGER **/

const menuMobile = document.querySelector('header nav');
const buttonMobile = document.querySelector('.button-mobile');

buttonMobile.addEventListener('click', () => {
  menuMobile.classList.toggle('openMenu');
  buttonMobile.classList.toggle('crossBurger');
});




/** MODALE CONTACT **/

const modalContact = document.querySelector('#myModal');
const buttonContact = document.querySelector('.menu-item-25');

buttonContact.addEventListener('click', () => {
  modalContact.classList.toggle('openModal');
  /** fermer le menu burger **/
  menuMobile.classList.remove('openMenu');
  buttonMobile.classList.remove('crossBurger');
});

/** fermeture de la modale - Clic en dehors **/
window.onclick = function(event) {
  if (event.target == modalContact) {
    modalContact.classList.remove('openModal');
    modalContact.classList.remove('openMenu');
  }
}