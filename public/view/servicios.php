<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assests/img/logo2.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../assests/css/styles-servicios.css">
    <title>Servicios</title>
</head>
<body>

    <!--======================= HEADER===============-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="../../index.php" class="nav__logo">
                <img src="../assests/img/logo2.png" alt="" class="nav__logo-icon">GRUPONET
            </a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="../../index.php" class="nav__link">Inicio</a>
                    </li>
                    <li class="nav__item">
                        <a href="productos.php" class="nav__link">Productos</a>
                    </li>
                    <li class="nav__item">
                        <a href="#Servicios.php" class="nav__link active">Servicios</a>
                    </li>
                    <li class="nav__item">
                        <a href="nosotros.php" class="nav__link">Nosotros</a>
                    </li>
                    <li class="nav__item">
                        <a href="envios.php" class="nav__link">Envios</a>
                    </li>
                </ul>

                <div class="nav__close" id="nav-close">
                    <i class='bx bx-x'></i>
                </div>
            </div>

            <div class="nav__btns">
                <div class="nav__shop" id="cart-shop">
                    <i class='bx bx-shopping-bag'></i>
                </div>

                <div class="nav__toggle" id="nav-toggle">
                    <i class='bx bx-grid-alt'></i>
                </div>
            </div>
        </nav>
    </header>

    <!--======================= MAIN ==========================-->
    <main class="main">
        <!--================ SERVICIO TECNICO ==========================-->
        <section class="about section container" id="about">
            <h2 class="section__title about">
                Servicio Técnico & <br> Electrónico
            </h2>
            <div class="about__container grid">
                <img src="../assests/img/serviciotecnico.jpg" alt="" class="about__img">
    
                <div class="about__data">
                    <h2 class=" about__title">
                        SERVICIO TÉCNICO
                    </h2>
                    <p class="about__description">
                        Contamos con profesionales dedicados a instalar, 
                        reparar y hacer el mantenimiento en Notebooks o Laptops, 
                        CPU, Macbook y IMAC. ¿Qué falla presenta tu dispositivo?
                    </p>
    
                    <div class="about__details">
                        <p class="about__details-description">
                            <i class='bx bxs-check-square about__details-icon'></i>
                            Mantenimiento Físico.
                        </p>
    
                        <p class="about__details-description">
                            <i class='bx bxs-check-square about__details-icon'></i>
                            Sistema Operativo.
                        </p>
    
                        <p class="about__details-description">
                            <i class='bx bxs-check-square about__details-icon'></i>
                            Instalación de repuestos.
                        </p>
    
                        <p class="about__details-description">
                            <i class='bx bxs-check-square about__details-icon'></i>
                            Reparación y reconstrucción.
                        </p>
    
                        <p class="about__details-description">
                            <i class='bx bxs-check-square about__details-icon'></i>
                            Flasheo BIOS.
                        </p>
    
                        <p class="about__details-description">
                            <i class='bx bxs-check-square about__details-icon'></i>
                            Reflux.
                        </p>
                    </div>

                    <a href="servicio-tecnico.php" class="button button--small">Saber más</a>
                </div>
            </div>
        </section>

        <!--=================== SERVICIO ELECTRONICO ===================-->
        <section class="story section container">
            <div class="story__container grid">
                <div class="story__data">
                    <h2 class="section__title story__section-title">
                        SERVICIO ELECTRÓNICO
                    </h2>

                    <h1 class="story__title">
                        REPARACIÓN DE TARJETAS
                    </h1>

                    <p class="story__description">
                        Servicio especializado en reparación de tarjetas con fallas complejas en laptops. 
                        Solucionamos problemas de encendido, pantalla, energía, líquidos, cortocircuitos y batería. 
                        Si la falla no tiene reparación, ofrecemos remplazo de la motherboard a un precio especial. 
                        Expertos con amplia experiencia para dar solución a tu equipo.
                    </p>

                    <a href="https://api.whatsapp.com/send/?phone=51961146060&text&type=phone_number&app_absent=0" target="_blank" class="button button--small">Contratar</a>
                </div>

                <div class="story__images">
                    <img src="../assests/img/servicioelectronico.jpg" alt="#" class="story__img">
                    <div class="story__square"></div>
                </div>
            </div>
        </section>


    </main>

    <!--====================== FOOTER ===========================-->
    <footer class="footer section">
        <div class="footer__container container grid">
            <div class="footer__content">
                <h3 class="footer__title">Información</h3>

                <ul class="footer__list">
                    <a href="https://www.google.com/maps/place/Gruponet/@-11.9457532,-77.0628188,17z/data=!3m1!4b1!4m6!3m5!1s0x9105d1d39637f4f3:0x8d76e2f2ab859a57!8m2!3d-11.9457585!4d-77.0602439!16s%2Fg%2F11c1qcgsk_" class="footer__link" target="_blank">
                        <li>Av. Universitaria 6504 <br> Comas 15312</li>
                    </a>
                    <li>Celular <br> 961146060</li>
                    <li>Atención <br>
                        Lunes - Viernes: 9am a 7pm <br>
                        Sábado: 9am a 4pm
                    </li>
                </ul>
            </div>

            <div class="footer__content">
                <h3 class="footer__title">Servicios</h3>

                <ul class="footer__links">
                    <li>
                        <a href="#" class="footer__link">Servicio Electrónico</a>
                    </li>

                    <li>
                        <a href="#" class="footer__link">Servicio Técnico</a>
                    </li>

                    <li>
                        <a href="https://wa.me/51961146060?text=REQUIERO%20SERVICIO%20TECNICO%20-%20Diagnostico%20" target="_blank" class="footer__link">Diagnóstico</a>
                    </li>

                    <li>
                        <a href="https://wa.me/51961146060?text=REQUIERO%20SERVICIO%20TECNICO%20-%20Mantenimiento%20" target="_blank" class="footer__link">Mantenimiento</a>
                    </li>

                    <li>
                        <a href="https://wa.me/51961146060?text=REQUIERO%20SERVICIO%20TECNICO%20-%20Sistema%20Operativo%20" target="_blank" class="footer__link">Sistema Operativo</a>
                    </li>
                </ul>
            </div>

            <div class="footer__content">
                <h3 class="footer__title">Sobre Nosotros</h3>

                <ul class="footer__links">
                    <li>
                        <a href="https://wa.me/51961146060?text=Me%20gustaria%20realizar%20una%20consulta...%20" target="_blank" class="footer__link">Centro de Ayuda</a>
                    </li>

                    <li>
                        <a href="envios.php" class="footer__link">Atención al Cliente</a>
                    </li>

                    <li>
                        <a href="nosotros.php" class="footer__link">Nosotros</a>
                    </li>

                    <li>
                        <a href="copy.php" class="footer__link">CopyRight</a>
                    </li>
                </ul>
            </div>

            <div class="footer__content">
                <h3 class="footer__title">Redes Sociales</h3>

                <ul class="footer__social">
                    <a href="https://www.facebook.com/corporaciongruponet" target="_blank" class="footer__social-link">
                        <i class='bx bxl-facebook'></i>
                    </a>
                    <a href="https://www.tiktok.com/@corporaciongruponet?_t=8XLtCWDKPvZ&_r=1" target="_blank" class="footer__social-link">
                        <i class='bx bxl-tiktok'></i>
                    </a>
                    <a href="https://instagram.com/corporaciongruponet?igshid=YmMyMTA2M2Y=" target="_blank" class="footer__social-link">
                        <i class='bx bxl-instagram'></i>
                    </a>
                    <a href="https://www.youtube.com/channel/UCahpSqJDrtVHFGCgXSHcpaA" target="_blank" class="footer__social-link">
                        <i class='bx bxl-youtube'></i>
                    </a>
                </ul>
            </div>
        </div>

        <span class="footer__copy">&#169; Gruponet 2023. All rights reserved</span>
    </footer>


    <!--====================== SCROLL UP ====================-->
    <a href="#" class="scrollup" id="scroll-up">
        <i class='bx bx-up-arrow-alt scrollup__icon'></i>
    </a>

    <!--====================== SCROLL UP WHATSAPP ====================-->
    <a href="https://api.whatsapp.com/send/?phone=51961146060&text&type=phone_number&app_absent=0" target="_blank" class="scrollup1" id="scroll-up1">
        <i class='bx bxl-whatsapp scrollup__icon1' undefined ></i>
    </a>
    
    <script src="../assests/js/main-servicios.js"></script>

    
</body>
</html>