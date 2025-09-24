<?php
// Verifica si se proporciona un ID válido en la URL
if (isset($_REQUEST['id'])) {
    // Obtiene el ID del producto o promoción desde la URL
    $productoId = $_GET['id'];

    // Incluye tu archivo de conexión
    include '../../app/model/bd_conexion.php';

    // Escapa el ID del producto para evitar inyección SQL
    $productoId = $conexion->real_escape_string($productoId);

    // Consulta para obtener detalles de producto
    $queryProductos = "SELECT p.id_producto, p.name_product, c.name_categoria, m.name_marca, p.descripcion, p.precio_product, p.stock_product, p.img_product 
                FROM productos p 
                JOIN categoria c ON p.categoria_id = c.id_categoria
                JOIN marcas m ON p.marca_id = m.id_marca 
                WHERE p.id_producto = ?";



    // Preparar y ejecutar consulta para obtener detalles del producto
    $stmtProductos = $conexion->prepare($queryProductos);
    $stmtProductos->bind_param('i', $productoId);
    $stmtProductos->execute();
    $resultProductos = $stmtProductos->get_result();


    // Verifica si la consulta fue exitosa para productos
    if ($resultProductos && $resultProductos->num_rows > 0) {
        $data = $resultProductos->fetch_assoc();
    }
} else {
    // Si no se proporciona un ID válido, puedes mostrar un mensaje de error o redirigir a una página de error
    echo "ID no válido";
    // Opcional: redirigir a una página de error
    // header('Location: error.php');
    // exit();
}

$descripcion = $data["descripcion"];
$caracteristicas = explode("\n", $descripcion);

// Inicializa variables para las características
$caracteristicasTabla = [];

// Recorre las características y asigna a las variables correspondientes
foreach ($caracteristicas as $caracteristica) {
    $caracteristica = trim($caracteristica); // Elimina espacios en blanco
    $partes = explode(':', $caracteristica, 2); // Divide en nombre y valor

    if (count($partes) === 2) {
        $nombre = trim($partes[0]);
        $valor = trim($partes[1]);
        $caracteristicasTabla[$nombre] = $valor;
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../assests/img/logo2.png" type="image/png">

    <!--======================= BOX ICONS =======================-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!--======================= CSS =======================-->
    <link rel="stylesheet" href="../assests/css/styles-ver.css">

    <title>Productos</title>
</head>

<body>
    <!--======================= HEADER =====================-->
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
                        <a href="productos.php" class="nav__link active-link">Productos</a>
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
    <main class="">
        <section class="main-container pt-15px">
            <div class="text-interest">
                <br>
            </div>
            <div class="breadcrumbs-row">
                <section class="breadcrumbs">
                    <a href="productos.php" style="color: var(--text-color-light);">
                        <p>Volver al listado</p>
                    </a>

                    <nav>
                        <ol class="breadcrumbs-list">
                            <br>
                        </ol>
                    </nav>
                </section>
            </div>
        </section>

        <section class="main-container product-details-grid bg-white">

            <article class="right-column">

                <section class="product-g" id="product-g-mobile">
                    <div class="gallery-container">
                        <div class="thumbnail-container">
                            <img src="data:image/jpg;base64,<?php echo base64_encode($data['img_product']); ?>" alt="Imagen miniatura del producto" class="selected-thumbnail">

                        </div>
                        <div class="main-img">
                            <img src="data:image/jpg;base64,<?php echo base64_encode($data['img_product']); ?>" alt="Imagen del producto">
                        </div>
                    </div>
                </section>

                <section class="product-details">
                    <div class="zoom-lens" id="zoom" style="<?php echo "background-image: url('data:image/jpg;base64," . base64_encode($data['img_product']) . "');"; ?>"></div>

                    <div class="product-title ">
                        <h1><?php echo $data["name_product"] ?></h1>

                    </div>

                    <div class="product-price">
                        <h2>S/ <?php echo $data['precio_product'] ?></h2>

                    </div>

                    <ul class="card__list grid">
                        <?php
                        $array_des = explode("\n", $data['descripcion']);
                        if (!empty($data['descripcion'])) {
                        ?>
                            <ul class="card__list grid">
                                <?php
                                foreach ($array_des as $item) {
                                ?>
                                    <?php echo
                                    '<li class="card__list-item">' .
                                        "<i class='bx bx-check card__list-icon'></i>" .
                                        '<p class="card__list-description">' . $item . '</p>' .
                                        '</li>';
                                    ?>
                                <?php
                                }
                                ?>
                            </ul>
                        <?php
                        } else {
                            // Mostrar algo o simplemente dejarlo vacío
                            echo '<p class="card__list-description"></p>';
                        }
                        ?>
                    </ul>

                    <p class="available-stock">Stock disponible</p>

                    <span class="stock">
                        <p>Cantidad:&nbsp;</p>
                        <div class="select-menu">
                            <div class="select-btn">
                                <span class="sBtn-text" id="selectedQuantity"><b>1 unidad</b></span>
                                <i class='bx bx-chevron-down stock-down-arrow'></i>
                            </div>
                            <ul class="options" id="quantityOptions">
                                <?php
                                // Genera las opciones de cantidad según el stock disponible
                                for ($i = 1; $i <= $data["stock_product"]; $i++) {
                                    echo '<li class="option" onclick="selectQuantity(' . $i . ')"><span class="option-text">' . $i . ' unidad' . ($i > 1 ? 'es' : '') . '</span></li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <p class="available-quantity">(<?php echo $data["stock_product"] ?>)</p>
                    </span>

                    <button id="comprarAhoraBtn" class="btn-blue product-details-btn mb-8px">Comprar ahora mediante <i class='bx bxl-whatsapp'></i></button>

                    <script>
                        document.getElementById('comprarAhoraBtn').addEventListener('click', function() {
                            // Número de teléfono
                            var telefono = '961146060'; // Reemplaza con el número de teléfono al que deseas enviar el mensaje
                            var nombreProducto = '<?php echo $data["name_product"]; ?>';

                            // Obtiene la cantidad seleccionada
                            var cantidadSeleccionada = document.getElementById('selectedQuantity').innerText.split(' ')[0];

                            // Construye el mensaje con la cantidad seleccionada y el nombre del producto
                            var mensaje = 'Hola, quiero comprar ' + cantidadSeleccionada + ' ' + nombreProducto + '. ¿Puedes proporcionarme más detalles?';

                            // Construye el enlace de WhatsApp con el mensaje
                            var whatsappLink = 'https://wa.me/' + telefono + '?text=' + encodeURIComponent(mensaje);

                            // Abre una nueva ventana o pestaña con el enlace de WhatsApp
                            window.open(whatsappLink, '_blank');
                        });
                    </script>



                </section>

                <section class="additional-info-container mt-15px">
                    <div>
                        <h3 class="additional-info-subtitle mt-0 mb-12px">Garantía del producto</h3>
                        <p class="text-grey mb-24px">
                            Agradecemos sinceramente tu elección de nuestros productos. Queremos asegurarnos de que tu experiencia de compra sea lo más satisfactoria posible. Todos nuestros productos están respaldados por nuestra garantía de calidad. <br><br>
                        </p>

                        <h3 class="additional-info-subtitle mt-0 mb-12px">Garantía:</h3>
                        <p class="text-grey mb-24px">
                            Ofrecemos una garantía directa con nosotros para asegurar tu completa tranquilidad. Por favor, conserva cuidadosamente la nota de garantía que te fue entregada al momento de realizar tu compra. En caso de que surja algún problema con el producto, estaremos encantados de ayudarte.
                        </p>

                        <h3 class="additional-info-subtitle mt-0 mb-12px">Proceso de Garantía:</h3>
                        <p class="text-grey mb-24px">
                            1.-Conserva la nota de garantía original.<br><br>
                            2.-En caso de cualquier problema, ponte en contacto con nuestro servicio de atención al cliente a través de [correo electrónico/teléfono].<br><br>
                            3.-Proporciona la información detallada sobre el problema junto con el número de tu nota de garantía.<br><br>
                            4.-Nuestro equipo te guiará a través del proceso de garantía para resolver cualquier inconveniente de manera eficiente. <br><br>
                            Queremos asegurarnos de que tu satisfacción con nuestros productos sea total. Estamos comprometidos a brindarte el mejor servicio posible.<br><br>

                            Gracias por confiar en nosotros.
                         </p>
                    </div>
                </section>

            </article>

            <article class="left-column">
                <section class="product-g" id="product-g-desktop">
                    <div class="gallery-container">
                        <div class="thumbnail-container">
                            <img src="data:image/jpg;base64,<?php echo base64_encode($data['img_product']); ?>" onmouseover="changeImage('data:image/jpg;base64,<?php echo base64_encode($data['img_product']); ?>', 1)" class="selected-thumbnail" id="pic1">
                        </div>
                        <div class="main-img" id="picture" onmousemove="move(event)">
                            <div class="rect" id="rect"></div>
                            <img src="data:image/jpg;base64,<?php echo base64_encode($data['img_product']); ?>" alt="Imagen del producto" id="pic">
                        </div>
                    </div>
                </section>

                <div class="mx-30px">
                    <section>
                        <hr class="product-details-hr">
                        <h2 class="product-details-subtitle">Características principales</h2>
                        <table class="features-table">
                            <tbody>
                                <tr>
                                    <th class="feature-title">Tipo de producto</th>
                                    <td class="feature-value"><?php echo $data["name_categoria"] ?></td>
                                </tr>
                                <tr>
                                    <th class="feature-title">Marca</th>
                                    <td class="feature-value"><?php echo $data["name_marca"] ?></td>
                                </tr>
                                <?php
                                foreach ($caracteristicasTabla as $nombre => $valor) {
                                ?>
                                    <tr>
                                        <th class="feature-title"><?php echo $nombre; ?></th>
                                        <td class="feature-value"><?php echo $valor; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                    </section>
                </div>
            </article>

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
                        <a href="servicios.php" class="footer__link">Servicio Electrónico</a>
                    </li>

                    <li>
                        <a href="servicios.php" class="footer__link">Servicio Técnico</a>
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
    <a href="#" class="scrollup" id="scroll-up">
        <i class='bx bx-up-arrow-alt scrollup__icon'></i>
    </a>

    <script src="../assests/js/main-ver.js"></script>
</body>

</html>