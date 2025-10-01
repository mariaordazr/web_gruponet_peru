// public/assets/js/home.js

document.addEventListener('DOMContentLoaded', function() {

    /*=============== INITIALIZE HOME SLIDER (Swiper) ===============*/
    const homeSlider = new Swiper('.home-slider', {
        // CAMBIO: El efecto ahora es 'slide' para que una imagen empuje a la otra
        effect: 'slide',

        // Hace que el slider sea infinito
        loop: true,

        // Autoplay con la nueva configuración de pausa
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true, // CAMBIO: Pausa el slider al pasar el mouse por encima
        },

        // Elementos de paginación (los puntos de abajo)
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

        // Flechas de navegación
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    // El código personalizado para pausar en las flechas ya no es necesario y ha sido eliminado.
});