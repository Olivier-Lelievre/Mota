/** MENU BURGER **/

document.addEventListener( 'DOMContentLoaded', ( function() {
    /**
       * @param {HTMLElement} el
       * @param {string}      attr
       * @param {any}         value
       */
      const setAttr = ( el, attr, value ) => el.setAttribute( attr, value );
    
    /** @type {HTMLElement} */
    const siteNavigation = document.querySelector( 'nav' );
  
    if ( siteNavigation ) {
      /** @type {HTMLElement} */
      const mobileButton = siteNavigation.querySelector( 'button.menu-toggle' );
  
      /**
        * Au clic sur le bouton mobile, on affiche ou masque le menu :
        * - on ajouter/supprime la classe "toggled" sur la <nav> qui nous servira à masquer/afficher en css
        * - on passe l'attribut "aria-expanded" à true/false
        */
        if ( mobileButton ) {
          mobileButton.addEventListener( 'click', function() {
            siteNavigation.classList.toggle( 'toggled' );
  
            if ( mobileButton.getAttribute( 'aria-expanded' ) === 'true') {
              setAttr( mobileButton, 'aria-expanded', 'false' );
            } else {
              setAttr( mobileButton, 'aria-expanded', 'true' );
              console.log(mobileButton)
            }
          } );
        }
    }
    } ) );
  


/** MODALE **/

// Get the modal
var modal = document.getElementById('myModal');
// Get the button that opens the modal
var btn = document.getElementById("menu-item-25");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks on the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


// BURGER

const menu = document.querySelector('.burger-open');
const burger = document.querySelector('#site-navigation ul button');

burger.addEventListener('click', () => {
  menu.classList.toggle('open');
  burger.classList.toggle('crossBurger')
});

document.querySelectorAll(".link-burger").forEach(n => n.addEventListener("click", () => {
  menu.classList.remove("open");
  burger.classList.remove('crossBurger')
}));