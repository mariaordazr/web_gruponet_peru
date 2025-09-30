// public/assets/js/home.js

document.addEventListener('DOMContentLoaded', function() {

    /*=============== AUTOSLIDE HOME ===============*/
    const slides = document.getElementsByClassName("home__img");

    // Safety check: only run the slider if there are slides on the page
    if (slides.length > 0) {
        let slideIndex = 0;
        let slideInterval;

        function autoSlide() {
            for (let i = 0; i < slides.length; i++) {
                slides[i].classList.remove("active");
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }
            // The error was here: slides[slideIndex-1] could be undefined if slides.length was 0
            slides[slideIndex - 1].classList.add("active");
        }

        function startSlideShow() {
            stopSlideShow(); // Clear any existing interval
            slideInterval = setInterval(autoSlide, 5000); // 5 seconds
        }

        function stopSlideShow() {
            clearInterval(slideInterval);
        }

        startSlideShow();
    }
});