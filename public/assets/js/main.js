// public/assets/js/main.js

document.addEventListener('DOMContentLoaded', function() {

    /*=============== CHANGE BACKGROUND HEADER ===============*/
    function scrollHeader() {
        const header = document.getElementById('header');
        // When the scroll is greater than 50 viewport height, add the scroll-header class to the header tag
        if (this.scrollY >= 50) {
            header.classList.add('scroll-header');
        } else {
            header.classList.remove('scroll-header');
        }
    }
    window.addEventListener('scroll', scrollHeader);

    /*=============== SCROLL REVEAL INITIALIZATION ===============*/
    // This is the general initialization for animations
    // Page-specific animations will be in their own files
    const sr = ScrollReveal({
        origin: 'top',
        distance: '60px',
        duration: 2500,
        delay: 400,
    });

    // General reveals that might be on all pages
    sr.reveal(`.section__title`);
    sr.reveal(`.footer__container`);

});