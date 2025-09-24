<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../assests/img/favicon-fondog.png" type="image/png">

    <!--======================= BOX ICONS =======================-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!--======================= CSS =======================-->
    <link rel="stylesheet" href="../assests/css/styles-productos.css">

    <title>Productos</title>
</head>
<body>
    <!--======================= HEADER =====================-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="../../index.php" class="nav__logo">
                <img src="../assests/img/logo.png" alt="" class="nav__logo-icon">GRUPONET
            </a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item"> 
                        <a href="../../index.php" class="nav__link">Inicio</a>
                    </li>
                    <li class="nav__item">
                        <a href="#" class="nav__link active">Productos</a>
                    </li>
                    <li class="nav__item">
                        <a href="servicios.php" class="nav__link">Servicios</a>
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
    
    <!--=================== MAIN =====================-->
    <main class="main">
        <!--=================== HEADER ===================-->
        <div class="header__main">
            <div class="header__container">

                <a href="#" class="header__logo"></a>

                <div class="header__search">
                    <input type="search" placeholder="Search" class="header__input" oninput="buscarCards()">
                    <i class='bx bx-search header__icon'></i>
                </div>

                <div class="header__toggle">
                    <i class='bx bx-menu' id="header-toggle"></i>
                </div>
            </div>
        </div>

        <!--===================== NAV FILTRO ======================-->
        <div class="nav1" id="navbar">
            <div class="nav__container1">
                <div>
                    <div class="nav__link1 nav__logo1">
                        <i class='bx bxs-keyboard nav__icon1'></i>
                        <span class="mav__logo-name">Productos</span>
                    </div>

                    <div class="nav__list1">
                        <div class="nav__items1">
                            <h3 class="nav__subtitle"></h3>

                            <div class="nav__dropdown">
                                <a href="#" class="nav__link1 active">
                                    <span class="nav__name">Teclados</span>
                                    <i class='bx bxs-chevron-down nav__icon nav__dropdown-icon'></i>
                                </a>

                            <div class="nav__dropdown-collapse">
                                <div class="nav__dropdown-content">
                                    <a href="#" class="nav__dropdown-item">Blocked</a>
                                    <a href="#" class="nav__dropdown-item">Silenced</a>
                                    <a href="#" class="nav__dropdown-item">Publish</a>
                                    <a href="#" class="nav__dropdown-item">Program</a>
                                </div>
                            </div>

                            </div>

                            <div class="nav__dropdown">
                                <a href="#" class="nav__link1">
                                    <span class="nav__name">Cargadores</span>
                                </a>
                            </div>

                            <div class="nav__dropdown">
                                <a href="#" class="nav__link1">
                                    <span class="nav__name">Baterias</span>
                                </a>
                            </div>

                            <div class="nav__dropdown">
                                <a href="#" class="nav__link1">
                                    <span class="nav__name">Cables</span>
                                </a>
                            </div>

                            <div class="nav__dropdown">
                                <a href="#" class="nav__link1">
                                    <span class="nav__name">Fan Cooler</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--==================== PRODUCTS =======================-->
        <section class="products section container" id="products">

            <div class="products__container grid">
            <?php
                require("../../app/model/bd_conexion.php");
                if (!isset($_GET['id']) or $_GET['id'] == null or strlen($_GET['id']) == 0) {
                    $sql = $conexion->query("SELECT * FROM productos
                         INNER JOIN categoria ON productos.categoria_id = categoria.id_categoria
                                INNER JOIN marcas ON productos.marca_id = marcas.id_marca
                    ");

                    while ($resultado = $sql->fetch_assoc()) {

                ?>
                
                <article class="products__card">
                    <img src="data:image/jpg;base64,<?php echo base64_encode($resultado['img_product']) ?>" alt="" class="products__img">

                    <h3 class="products__title"><?php echo $resultado['name_product'] ?> </h3>
                    
                    <!-- Listar descripcion -->
                    
                    <ul class="card__list grid">
                    <?php
                        $array_des = explode("\n", $resultado['descripcion']);
                        foreach ($array_des as $item) {
                    ?>
                        <?php echo 
                            '<li class="card__list-item">'. 
                                "<i class='bx bx-check card__list-icon'></i>".
                                '<p class="card__list-description">' . $item . '</p>'.
                            '</li>';
                        ?>
                    <?php
                        }
                    ?>
                    </ul>
                    

                    <span class="products__price">S/. <?php echo $resultado['precio_product'] ?></span>

                    <span class="products__stock">Stock <?php echo $resultado['stock_product'] ?></span>

                    <button class="products__button">
                        <a href="../view/productos-vista.html" class="producto__link">
                            <i class='bx bx-shopping-bag'></i>
                        </a>                       
                    </button>
                </article>
                <?php
                    }
                }
                ?>
                
            </div>
            
            <!--================= ESTA ES LA ESTRUCTURA PARA LA PAGINACION ===================-->

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
                        <a href="servicios.php" class="footer__link">Servicio Electronico</a>
                    </li>

                    <li>
                        <a href="servicios.php" class="footer__link">Servicio Tecnico</a>
                    </li>

                    <li>
                        <a href="https://wa.me/51961146060?text=REQUIERO%20SERVICIO%20TECNICO%20-%20Diagnostico%20" target="_blank" class="footer__link">Diagnostico</a>
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
                        <a href="#" class="footer__link">CopyRight</a>
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
    <a href="https://api.whatsapp.com/send/?phone=51961146060&text&type=phone_number&app_absent=0" target="_blank" class="scrollup" id="scroll-up">
        <i class='bx bx-up-arrow-alt scrollup__icon'></i>
    </a>

    <script src="../assests/js/swiper-bundle.min.js"></script>

    <script src="../assests/js/main-productos.js"></script>
</body>
</html>