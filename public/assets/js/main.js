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

    /*=============== MOBILE MENU ===============*/
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const navMenu = document.getElementById('nav-menu');

    if (mobileMenuButton && navMenu) {
        mobileMenuButton.addEventListener('click', () => {
            navMenu.classList.toggle('is-active');
        });
    }

    /*=============== DROPDOWN MENUS ===============*/
    const dropdownToggles = document.querySelectorAll('[data-dropdown-toggle]');

    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(event) {
            event.preventDefault(); // Evita que el enlace '#' navegue
            const dropdownId = this.getAttribute('data-dropdown-toggle');
            const dropdownMenu = document.getElementById(dropdownId);
            
            // Cierra otros dropdowns abiertos
            document.querySelectorAll('.dropdown-menu.is-active').forEach(menu => {
                if (menu !== dropdownMenu) {
                    menu.classList.remove('is-active');
                }
            });

            // Muestra u oculta el dropdown actual
            dropdownMenu.classList.toggle('is-active');
        });
    });

    // Cierra los dropdowns si se hace clic fuera de ellos
    window.addEventListener('click', function(event) {
        if (!event.target.matches('[data-dropdown-toggle]')) {
            document.querySelectorAll('.dropdown-menu.is-active').forEach(menu => {
                menu.classList.remove('is-active');
            });
        }
    });

    // General reveals that might be on all pages
    sr.reveal(`.section__title`);
    sr.reveal(`.footer__container`);

});