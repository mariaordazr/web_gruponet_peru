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

    new Swiper('.product-page-carousel', {
        slidesPerView: 2,
        spaceBetween: 15,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            // para pantallas de 320px o más
            320: {
              slidesPerView: 2,
              spaceBetween: 10,
            },
            // para pantallas de 768px o más
            768: {
              slidesPerView: 4, // Ajustado para una mejor progresión
              spaceBetween: 15,
            },
            // para pantallas de 1024px o más
            1024: {
              slidesPerView: 6, // <-- CAMBIO PRINCIPAL: de 5 a 6
              spaceBetween: 20,
            },
        }
    });


    /*=============== INITIALIZE OFFERS CAROUSEL ===============*/
    new Swiper('.offers-carousel', {
        // slidesPerView: 'auto' es ideal para slides con ancho fijo
        slidesPerView: 'auto',
        spaceBetween: 15, // Espacio entre las tarjetas
        
        // Navegación con flechas
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    //*=============== INITIALIZE DISCOVER CAROUSEL ===============*/
    new Swiper('.discover-carousel', {
        slidesPerView: 2,
        spaceBetween: 15,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            640: { slidesPerView: 3, spaceBetween: 20 },
            768: { slidesPerView: 4, spaceBetween: 20 },
            1024: { slidesPerView: 5, spaceBetween: 20 },
        }
    });

    /*=============== DISCOVER TABS LOGIC ===============*/
    const tabs = document.querySelectorAll('.discover-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', function(event) {
            event.preventDefault();
            
            // Quita la clase activa de todas las pestañas
            tabs.forEach(t => t.classList.remove('is-active'));
            
            // Añade la clase activa a la pestaña clickeada
            this.classList.add('is-active');
            
            // Aquí iría la lógica para cambiar los productos del carrusel (Paso avanzado)
        });
    });
});
