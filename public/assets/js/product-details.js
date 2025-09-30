// public/assets/js/product-details.js
document.addEventListener('DOMContentLoaded', function() {
    /*=============== QUESTIONS ACCORDION ===============*/
    const accordionItems = document.querySelectorAll('.faq__item'); // Renombrado de .questions__item

    accordionItems.forEach((item) => {
        const accordionHeader = item.querySelector('.faq__header'); // Renombrado

        accordionHeader.addEventListener('click', () => {
            const openItem = document.querySelector('.accordion-open');
            toggleItem(item);
            if (openItem && openItem !== item) {
                toggleItem(openItem);
            }
        });
    });

    const toggleItem = (item) => {
        const accordionContent = item.querySelector('.faq__content'); // Renombrado
        if (item.classList.contains('accordion-open')) {
            accordionContent.removeAttribute('style');
            item.classList.remove('accordion-open');
        } else {
            accordionContent.style.height = accordionContent.scrollHeight + 'px';
            item.classList.add('accordion-open');
        }
    };

    /*=============== SCROLL REVEAL ANIMATION ===============*/
    const sr = ScrollReveal({ origin: 'bottom', distance: '60px', duration: 2500, delay: 400 });
    sr.reveal(`.product-view__container`, { interval: 100 }); // Renombrado de .ver__container
});