/*================== SHOW MENU =======================*/
const navMenu = document.getElementById('nav-menu'),
      navToggle = document.getElementById('nav-toggle'),
      navClose = document.getElementById('nav-close')

/*===== MENU SHOW =====*/
/* Validate if constant exists */
if(navToggle){
    navToggle.addEventListener('click', () =>{
        navMenu.classList.add('show-menu')
    })
}

/*===== MENU HIDDEN =====*/
/* Validate if constant exists */
if(navClose){
    navClose.addEventListener('click', () =>{
        navMenu.classList.remove('show-menu')
    })
}

/*=============== REMOVE MENU MOBILE ===============*/
const navLink = document.querySelectorAll('.nav__link')

function linkAction(){
    const navMenu = document.getElementById('nav-menu')
    // When we click on each nav__link, we remove the show-menu class
    navMenu.classList.remove('show-menu')
}
navLink.forEach(n => n.addEventListener('click', linkAction))

/*==================== LINK ACTIVE ====================*/
const linkColor1 = document.querySelectorAll('.nav__link')

function colorLink(){
  linkColor.forEach(l => l.classList.remove('active'))
  this.classList.add('active')
}

/*=============== CHANGE BACKGROUND HEADER ===============*/
function scrollHeader(){
    const header = document.getElementById('header')
    // When the scroll is greater than 50 viewport height, add the scroll-header class to the header tag
    if(this.scrollY >= 50) header.classList.add('scroll-header'); else header.classList.remove('scroll-header')
}
window.addEventListener('scroll', scrollHeader)

/*=============== SHOW SCROLL UP ===============*/ 
function scrollUp(){
  const scrollUp = document.getElementById('scroll-up');
  // When the scroll is higher than 400 viewport height, add the show-scroll class to the a tag with the scroll-top class
  if(this.scrollY >= 400) scrollUp.classList.add('show-scroll'); else scrollUp.classList.remove('show-scroll')
}
window.addEventListener('scroll', scrollUp)

/*================ SLIDER ===================*/
    // Configuración del slider
    var sliderIndex = 0;
    var sliderImages = document.querySelectorAll('.slider img');
    var sliderInterval = setInterval(autoSlide, 5000);

    // Función para cambiar de imagen automáticamente
    function autoSlide() {
      for (var i = 0; i < sliderImages.length; i++) {
        sliderImages[i].classList.remove('active');
      }
      sliderIndex++;
      if (sliderIndex >= sliderImages.length) {
        sliderIndex = 0;
      }
      sliderImages[sliderIndex].classList.add('active');
    }

/*=============== SHOW SCROLL UP WHATSAPP ===============*/ 
function scrollUp1(){
  const scrollUp = document.getElementById('scroll-up1');
  // When the scroll is higher than 400 viewport height, add the show-scroll class to the a tag with the scroll-top class
  if(this.scrollY >= 400) scrollUp.classList.add('show-scroll1'); else scrollUp.classList.remove('show-scroll1')
}
window.addEventListener('scroll', scrollUp1)


