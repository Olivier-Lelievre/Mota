document.addEventListener('DOMContentLoaded', () => {
    const lightbox = document.querySelector('#myLightbox');
    const lightboxImg = document.querySelector('#lightbox-img');
    const lightboxRef = document.querySelector('#lightbox-ref');
    const lightboxCat = document.querySelector('#lightbox-cat');
    const closeBtn = document.querySelector('.close-lightbox');
    const nextBtn = document.querySelector('#lightbox-next');
    const prevBtn = document.querySelector('#lightbox-prev');
    let currentIndex = 0;
    let photos = [];

    // Fonction pour ouvrir la lightbox
    function openLightbox(index) {
        const photo = photos[index];
        lightboxImg.src = photo.src;
        lightboxRef.textContent = `Réf. ${photo.ref}`;
        lightboxCat.textContent = `${photo.cat}`;
        lightbox.classList.add('openLightbox');
        currentIndex = index;
    }

    // Fonction pour charger les photos depuis le DOM
    function loadPhotos() {
        photos = [];
        document.querySelectorAll('.photo-item').forEach((item, index) => {
            const photoData = {
                src: item.dataset.src,
                ref: item.dataset.ref,
                cat: item.dataset.cat,
                url: item.dataset.url // Récupère l'URL
            };
            photos.push(photoData);

            // Événement pour ouvrir la lightbox
            item.querySelector('.bt-overlayLightbox').addEventListener('click', (e) => {
                e.preventDefault();
                openLightbox(index);
            });

            // Événement pour ouvrir la page individuelle
            item.querySelector('.bt-overlaySinglePhoto').addEventListener('click', (e) => {
                e.preventDefault();
                window.location.href = photoData.url; // Redirection vers l'URL
            });
        });
    }

    // Navigation
    function showNext() {
        // Le modulo (%) garantit que l'index reste dans les limites du tableau photos. Sinon revient à 0.
        currentIndex = (currentIndex + 1) % photos.length;
        openLightbox(currentIndex);
    }

    function showPrev() {
        currentIndex = (currentIndex - 1 + photos.length) % photos.length;
        openLightbox(currentIndex);
    }

    // Fermer la lightbox
    function closeLightbox() {
        lightbox.classList.remove('openLightbox');
    }

    // Ajouter les événements
    closeBtn.addEventListener('click', closeLightbox);
    nextBtn.addEventListener('click', showNext);
    prevBtn.addEventListener('click', showPrev);
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) closeLightbox();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowRight') showNext();
        if (e.key === 'ArrowLeft') showPrev();
    });

    // Charger les photos initiales
    loadPhotos();

    // Recharger les photos après un chargement Ajax
    const observer = new MutationObserver(() => {
        const gallery = document.querySelector('.image-gallery');
        if (gallery) {
            observer.disconnect(); // Arrête l'observation après la première détection
            const innerObserver = new MutationObserver(loadPhotos);
            innerObserver.observe(gallery, { childList: true });
        }
    });
    observer.observe(document.body, { childList: true, subtree: true });    
});
