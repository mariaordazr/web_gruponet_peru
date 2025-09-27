<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="assests/img/logo2.png" type="image/png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <link rel="stylesheet" href="assests/css/styles.css">

    <title>GRUPONET</title>
</head>

<body>
    <!--======================= HEADER===============-->
    <header class="header" id="header">
        <nav class="nav container">
            <div class="div__logo">
                <a href="index.php" class="nav__logo">
                    <img src="assests/img/logo_texto_prueba.png" alt="" class="nav__logo-icon">
                </a>
            </div>


            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="#home" class="nav__link active">Inicio</a>
                    </li>
                    <li class="nav__item">
                        <a href="view/productos.php" class="nav__link">Productos</a>
                    </li>
                    <li class="nav__item">
                        <a href="view/servicios.php" class="nav__link">Servicios</a>
                    </li>
                    <li class="nav__item">
                        <a href="view/nosotros.php" class="nav__link">Nosotros</a>
                    </li>
                    <li class="nav__item">
                        <a href="view/envios.php" class="nav__link">Envios</a>
                    </li>
                </ul>

                <div class="nav__close" id="nav-close">
                    <i class='bx bx-x'></i>
                </div>
            </div>

            <div class="nav__btns">
                <div class="nav__shop" id="cart-shop">
                    <a href="view/productos.php" class="nav__shop">
                        <i class='bx bx-search-alt'></i>
                    </a>
                </div>

                <div class="nav__toggle" id="nav-toggle">
                    <i class='bx bx-grid-alt'></i>
                </div>
            </div>
        </nav>
    </header>

    <!--======================= MAIN ====================-->
    <main class="main">
        <!--============== HOME ===============-->
        <section class="home" id="home">
            <?php
            include "../app/model/bd_conexion.php";
            $sql = $conexion->query("SELECT * FROM portadas");
            ?>
            <div class="slider">
                <?php
                // Asegúrate de que tu consulta SQL ahora selecciona la nueva columna, por ejemplo:
                // $sql = $conexion->query("SELECT nombre_imagen FROM portadas");

                while ($datos = $sql->fetch_object()) {
                ?>
                    <img src="uploads/portadas/<?= htmlspecialchars($datos->img_portada) ?>" alt="" class="home__img active">
                <?php } ?>
            </div>

            <div class="home__container container1 grid1">
                <div class="home__data">
                    <span class="home__data-subtitle">Bienvenidos</span>
                    <h1 class="home__data-title">Corporación <br><b>GRUPONET SAC</b></h1>
                    <a href="https://api.whatsapp.com/send/?phone=51961146060&text&type=phone_number&app_absent=0" target="_blank" class="button">Contáctanos</a>

                </div>

                <div class="home__social">
                    <a href="https://www.facebook.com/corporaciongruponet" target="_blank" class="home__social-link">
                        <i class='bx bxl-facebook-square'></i>
                    </a>
                    <a href="https://instagram.com/corporaciongruponet?igshid=YmMyMTA2M2Y=" target="_blank" class="home__social-link">
                        <i class='bx bxl-instagram-alt'></i>
                    </a>
                    <a href="https://www.youtube.com/channel/UCahpSqJDrtVHFGCgXSHcpaA" target="_blank" class="home__social-link">
                        <i class='bx bxl-youtube'></i>
                    </a>
                </div>

                <div class="home__info">
                    <div>
                        <span class="home__info-title">Visita nuestros trabajos</span>
                        <a href="https://www.youtube.com/channel/UCahpSqJDrtVHFGCgXSHcpaA" class="button button--flex button--link home__info-button" target="_blank">
                            Ver <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>

                    <div class="home__info-overlay">
                        <img src="assests/img/slider2.jpg" alt="" class="home__info-img">
                    </div>
                </div>
            </div>
        </section>
        <!--================= PROMOCIONES ====================-->

        <section class="products section">
            <h2 class="section__title">
                RECIÉN LLEGADOS
            </h2>

            <div class="products__container bd-grid">
                <?php
                require("../app/model/bd_conexion.php");

                $sql = $conexion->query("SELECT * FROM promociones");
                $cardIndex = 1; // Variable para llevar un seguimiento del índice de la tarjeta

                while ($resultado = $sql->fetch_assoc()) {
                    $cardClass = "card card-" . $cardIndex; // Genera una clase única para cada tarjeta
                    $cardIndex++;
                    $nombreOferta = $resultado['nombre_ofert'];

                ?>
                    <article class="card <?php echo $cardClass; ?>">
                        <div class="card__img">
                            <img src="data:image/jpg;base64,<?php echo base64_encode($resultado['im_oferta']) ?>" alt="">
                        </div>
                        <div class="card__name">
                            <p><?php echo $resultado['nombre_ofert'] ?></p>
                        </div>
                        <div class="card__precis">
                            <a target="_self" href="view/productos-recien.php?id=<?php echo $resultado['id_oferta']; ?>" class="card__icon"><ion-icon name="add-circle-outline"></ion-icon></ion-icon></a>

                            <div>
                                <!--<span class="card__preci card__preci--before">S/. <?php echo $resultado['precio_normal'] ?></span>-->
                                <span class="card__preci card__preci--now">S/. <?php echo $resultado['precio_des'] ?></span>
                            </div>
                            <a href="https://wa.me/51961146060?text=<?php echo urlencode('Hola, estoy interesado en el producto ' . $nombreOferta . '. ¿Me podrías proporcionar más detalles?'); ?>" target="_blank" class="card__icon"><ion-icon name="logo-whatsapp"></ion-icon></ion-icon></a>
                        </div>
                    </article>
                <?php
                }
                ?>

            </div>
        </section>

        <!--==================== PRODUCTOS NUEVOS =======================-->
        <section class="featured section container" id="featured">
            <h2 class="section__title">
                liquidación
            </h2>

            <div class="featured__container grid">
                <!-- bucle -->
                <?php
                require("../app/model/bd_conexion.php");

                $sql = $conexion->query("SELECT * FROM nuevo_liquidaccion");


                while ($resultado = $sql->fetch_assoc()) {
                    $nombreProducto = $resultado['nombre_nuevo'];

                ?>
                    <article class="featured__card">
                        <span class="featured__tag">Oferta</span>
                        <img src="data:image/jpg;base64,<?php echo base64_encode($resultado['img_nuevo']) ?>" alt="" class="featured__img">

                        <div class="featured__data">
                            <h3 class="featured__title"><?php echo $resultado['nombre_nuevo'] ?></h3>
                            <span class="featured__price">S/. <?php echo $resultado['precio_product'] ?></span>
                        </div>
                        <a href="https://wa.me/51961146060?text=<?php echo urlencode('Hola, estoy interesado en el producto ' . $nombreProducto . '. ¿Me podrías proporcionar más detalles?'); ?>" target="_blank">
                            <button class="button featured__button">
                                OFERTA ESPECIAL
                            </button>
                        </a>

                    </article>
                <?php
                }
                ?>

            </div>
        </section>
    </main>

    <!--====================== FOOTER ===========================-->
    <footer class="footer section">
        <div class="footer__container container grid">
            <div class="footer__content">
                <h3 class="footer__title">Información</h3>

                <ul class="footer__list">
                    <li>
                        <a href="https://www.google.com/maps/place/Gruponet/@-11.9457532,-77.0628188,17z/data=!3m1!4b1!4m6!3m5!1s0x9105d1d39637f4f3:0x8d76e2f2ab859a57!8m2!3d-11.9457585!4d-77.0602439!16s%2Fg%2F11c1qcgsk_" class="footer__link" target="_blank">
                            Av. Universitaria 6504 <br> Comas 15312
                        </a>

                    </li>

                    <li>Celular <br> 961146060</li>
                    <li>Atencion <br>
                        Lunes - Viernes: 9am a 7pm <br>
                        Sabado: 9am a 4pm
                    </li>
                </ul>
            </div>

            <div class="footer__content">
                <h3 class="footer__title">Servicios</h3>

                <ul class="footer__links">
                    <li>
                        <a href="view/servicios.php" class="footer__link">Servicio Electronico</a>
                    </li>

                    <li>
                        <a href="view/servicios.php" class="footer__link">Servicio Tecnico</a>
                    </li>

                    <li>
                        <a href="https://wa.me/51961146060?text=REQUIERO%20SERVICIO%20TECNICO%20-%20Diagnostico%20" class="footer__link" target="_blank">Diagnostico</a>
                    </li>

                    <li>
                        <a href="https://wa.me/51961146060?text=REQUIERO%20SERVICIO%20TECNICO%20-%20Mantenimiento%20" class="footer__link" target="_blank">Mantenimiento</a>
                    </li>

                    <li>
                        <a href="https://wa.me/51961146060?text=REQUIERO%20SERVICIO%20TECNICO%20-%20Sistema%20Operativo%20" class="footer__link" target="_blank">Sistema Operativo</a>
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
                        <a href="view/envios.php" class="footer__link">Atención al Cliente</a>
                    </li>

                    <li>
                        <a href="view/nosotros.php" class="footer__link">Nosotros</a>
                    </li>

                    <li>
                        <a href="view/copy.php" class="footer__link">CopyRight</a>
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
                
                <div class="footer__content-logo">
                    <img class="logo_redes-footer" src="assests/img/logo-redes.webp" alt="logo-redes">
                </div>
            </div>
        </div>

        <span class="footer__copy">&#169; Gruponet 2023. All rights reserved</span>
    </footer>

    <!--====================== SCROLL UP ====================-->
    <a href="#" class="scrollup" id="scroll-up">
        <i class='bx bx-up-arrow-alt scrollup__icon'></i>
    </a>

    <!--====================== SCROLL UP WHATSAPP ====================-->
    <a href="https://api.whatsapp.com/send/?phone=51961146060&text&type=phone_number&app_absent=0" target="_blank" class="scrollup1" id="scroll-up1" target="_blank">
        <i class='bx bxl-whatsapp scrollup__icon1'></i>
    </a>

    <script src="assests/js/main-inicio.js"></script>
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

</body>

</html>