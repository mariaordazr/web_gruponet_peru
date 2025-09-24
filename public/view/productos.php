<?php
require("../../app/model/bd_conexion.php");

// Define una función para obtener productos según los filtros
function getProducts($conexion, $productosPorPagina, $paginaActual, $id_categoria, $searchTerms)
{
    // Calcula el inicio de la fila para la consulta LIMIT
    $inicio = ($paginaActual - 1) * $productosPorPagina;

    // Consulta SQL base
    $sqlQuery = "SELECT * FROM productos
    INNER JOIN categoria ON productos.categoria_id = categoria.id_categoria
    INNER JOIN marcas ON productos.marca_id = marcas.id_marca
    WHERE ";

    // Construye dinámicamente la parte de la consulta para buscar cada palabra clave
    $clauses = [];
    foreach ($searchTerms as $term) {
        $clauses[] = "(name_product LIKE '%$term%' OR descripcion LIKE '%$term%')";
    }
    $sqlQuery .= implode(" AND ", $clauses);

    // Si se selecciona una categoría, agrega una condición para filtrar por categoría
    if (!empty($id_categoria)) {
        $sqlQuery .= " AND categoria.id_categoria = $id_categoria";
    }

    // Agrega LIMIT a la consulta SQL
    $sqlQuery .= " LIMIT $inicio, $productosPorPagina";

    // Ejecuta la consulta SQL para obtener los productos
    $result = $conexion->query($sqlQuery);

    return $result;
}

// Define una función para contar la cantidad total de productos según la categoría o búsqueda
function countProducts($conexion, $id_categoria, $searchTerms)
{
    // Consulta SQL base
    $sqlCount = "SELECT COUNT(*) FROM productos
    INNER JOIN categoria ON productos.categoria_id = categoria.id_categoria
    INNER JOIN marcas ON productos.marca_id = marcas.id_marca
    WHERE ";

    // Construye dinámicamente la parte de la consulta para buscar cada palabra clave
    $clauses = [];
    foreach ($searchTerms as $term) {
        $clauses[] = "(name_product LIKE '%$term%' OR descripcion LIKE '%$term%')";
    }
    $sqlCount .= implode(" AND ", $clauses);

    // Si se selecciona una categoría, agrega una condición para filtrar por categoría
    if (!empty($id_categoria)) {
        $sqlCount .= " AND categoria.id_categoria = $id_categoria";
    }

    // Ejecuta la consulta SQL para contar
    $totalProductos = $conexion->query($sqlCount)->fetch_row()[0];

    return $totalProductos;
}

$productosPorPagina = 21;
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$id_categoria = isset($_GET['id_categoria']) ? $_GET['id_categoria'] : '';
$terminoBusqueda = isset($_GET['search']) ? $_GET['search'] : '';
$searchTerms = explode(" ", $terminoBusqueda);

$totalProductos = countProducts($conexion, $id_categoria, $searchTerms);
$totalPaginas = ceil($totalProductos / $productosPorPagina);

$sql = getProducts($conexion, $productosPorPagina, $current_page, $id_categoria, $searchTerms);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assests/img/favicon-fondog.png" type="image/png">

    <!--======================= BOX ICONS =======================-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
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

                <form method="GET" action="productos.php" class="header__search" id="search-form">
                    <input type="search" name="search" class="header__input" placeholder="Buscar productos">
                    <button type="submit"><i class='bx bx-search header__icon'></i></button>
                </form>


                <div class="header__toggle">
                    <i class='bx bx-menu' id="header-toggle"></i>
                </div>
            </div>

        </div>
        <!--===================== NAV FILTRO ======================-->
        <div class="nav1" id="navbar">
            <div class="nav__container1">
                <div>
                    <div class="nav__menu-1">
                        <i class='bx bx-menu nav__icon1'></i>
                        <a class="nav__link1 nav__logo1" href="productos.php">
                            <span class="mav__logo-name">Productos</span>
                        </a>
                    </div>

                    <div class="nav__list1">
                        <div class="nav__items1">
                            <?php
                            require("../../app/model/bd_conexion.php");

                            $sql1 = $conexion->query("SELECT DISTINCT categoria.id_categoria, categoria.name_categoria FROM productos
                            INNER JOIN categoria ON productos.categoria_id = categoria.id_categoria
                            ");
                            ?>

                            <?php
                            while ($resultado1 = $sql1->fetch_assoc()) {
                                $categoryId = (isset($_GET['id_categoria'])) ? $_GET['id_categoria'] : null;
                                $activeClass = ($categoryId == $resultado1['id_categoria']) ? 'active' : '';
                                $idMarcaSeleccionada = isset($_GET['id_marca']) ? $_GET['id_marca'] : null;
                            ?>
                                <div class="nav__dropdown">
                                    <div class="nav__drop-content">
                                        <a href="productos.php?id_categoria=<?php echo $resultado1['id_categoria'] ?>" class="nav__link1 <?php echo $activeClass; ?>">
                                            <span class="nav__name"><?php echo $resultado1['name_categoria'] ?></span>
                                        </a>
                                        <i class='bx bxs-chevron-down nav__icon nav__dropdown-icon'></i>
                                    </div>

                                    <div class="nav__dropdown-collapse">
                                        <div class="nav__dropdown-content">
                                            <?php
                                            // Consulta para obtener las marcas asociadas a esta categoría
                                            $categoryId = $resultado1['id_categoria'];
                                            $sqlMarcas = $conexion->query("SELECT DISTINCT marcas.id_marca, marcas.name_marca FROM productos
                                                INNER JOIN marcas ON productos.marca_id = marcas.id_marca
                                                WHERE productos.categoria_id = $categoryId");

                                            while ($resultadoMarca = $sqlMarcas->fetch_assoc()) {
                                                $marcaId = $resultadoMarca['id_marca'];
                                                $marcaActiva = ($idMarcaSeleccionada == $marcaId) ? 'active' : ''; // Verificar si la marca está activa
                                            ?>
                                                <a href="productos.php?id_categoria=<?php echo $resultado1['id_categoria']; ?>&id_marca=<?php echo $marcaId; ?>" class="nav__dropdown-item <?php echo $marcaActiva; ?>">
                                                    <?php echo $resultadoMarca['name_marca']; ?>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--==================== PRODUCTS =======================-->
        <section class="products section container" id="products">

            <div class="products__container grid">

                <?php
                $sqlQuery = ""; // Inicializa la variable antes del condicional
                // Consulta SQL con LIMIT para obtener los productos de la página actual
                if (isset($_GET['id_categoria']) && !empty($_GET['id_categoria'])) {
                    // Construir la consulta para filtrar por categoría
                    $sqlQuery = "SELECT * FROM productos
                            INNER JOIN categoria ON productos.categoria_id = categoria.id_categoria
                            INNER JOIN marcas ON productos.marca_id = marcas.id_marca
                            WHERE 1 = 1";

                    // Agregar condición para filtrar por categoría
                    $sqlQuery .= " AND categoria.id_categoria = {$_GET['id_categoria']}";

                    // Si hay filtro por marca, agregar la condición correspondiente
                    if (isset($_GET['id_marca']) && !empty($_GET['id_marca'])) {
                        $sqlQuery .= " AND marcas.id_marca = {$_GET['id_marca']}";
                    }

                    // Ejecutar consulta SQL
                    $result = $conexion->query($sqlQuery);

                    // Mostrar productos filtrados por categoría
                    while ($resultado = $result->fetch_assoc()) {
                ?>
                        <article class="products__card">
                            <a target="_self" href="productos-vista.php?id=<?php echo $resultado['id_producto']; ?>">
                                <img src="data:image/jpg;base64,<?php echo base64_encode($resultado['img_product']) ?>" alt="imagen" class="products__img">
                            </a>
                            <hr>

                            <a target="_self" href="productos-vista.php?id=<?php echo $resultado['id_producto']; ?>">
                                <h3 class="products__marca"><?php echo $resultado['name_marca'] ?> </h3>
                                <h3 class="products__title"><?php echo $resultado['name_product'] ?> </h3>
                                <h3 class="products__price">S/. <?php echo $resultado['precio_product'] ?></h3>
                            </a>

                            <!-- Listar descripcion -->
                            <?php
                            $array_des = explode("\n", $resultado['descripcion']);
                            if (!empty($resultado['descripcion'])) {
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

                            <button class="products__button" onclick="sendWhatsAppMessage('<?php echo $resultado['name_product']; ?>')">
                                <i class='bx bxl-whatsapp'></i>
                            </button>
                        </article>

                        <script>
                            function sendWhatsAppMessage(productName) {
                                var phoneNumber = '51961146060'; // Reemplaza con el número de teléfono al que deseas enviar el mensaje
                                var message = 'Hola, estoy interesado en el producto ' + productName + '. ¿Puedes proporcionarme más detalles?';
                                var whatsappLink = 'https://wa.me/' + phoneNumber + '?text=' + encodeURIComponent(message);
                                window.open(whatsappLink, '_blank');
                            }
                        </script>

                    <?php
                    }
                } else {

                    // Mostrar todos los productos
                    while ($resultado = $sql->fetch_assoc()) {
                    ?>
                        <article class="products__card">
                            <a target="_self" href="productos-vista.php?id=<?php echo $resultado['id_producto']; ?>">
                                <img src="data:image/jpg;base64,<?php echo base64_encode($resultado['img_product']) ?>" alt="imagen" class="products__img">
                            </a>
                            <hr>

                            <a target="_self" href="productos-vista.php?id=<?php echo $resultado['id_producto']; ?>">
                                <h3 class="products__marca"><?php echo $resultado['name_marca'] ?> </h3>
                                <h3 class="products__title"><?php echo $resultado['name_product'] ?> </h3>
                                <h3 class="products__price">S/. <?php echo $resultado['precio_product'] ?></h3>
                            </a>

                            <!-- Listar descripcion -->
                            <?php
                            $array_des = explode("\n", $resultado['descripcion']);
                            if (!empty($resultado['descripcion'])) {
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

                            <button class="products__button" onclick="sendWhatsAppMessage('<?php echo $resultado['name_product']; ?>')">
                                <i class='bx bxl-whatsapp'></i>
                            </button>
                        </article>

                        <script>
                            function sendWhatsAppMessage(productName) {
                                var phoneNumber = '51961146060'; // Reemplaza con el número de teléfono al que deseas enviar el mensaje
                                var message = 'Hola, estoy interesado en el producto ' + productName + '. ¿Puedes proporcionarme más detalles?';
                                var whatsappLink = 'https://wa.me/' + phoneNumber + '?text=' + encodeURIComponent(message);
                                window.open(whatsappLink, '_blank');
                            }
                        </script>
                <?php
                    }
                }
                ?>

            </div>

            <div class="pagination">
                <?php if ($current_page > 1) : ?>
                    <a href="?page=<?php echo $current_page - 1; ?><?php if (!empty($_GET['search'])) echo '&search=' . $_GET['search']; ?><?php if (!empty($_GET['sort'])) echo '&sort=' . $_GET['sort']; ?><?php if (!empty($_GET['order'])) echo '&order=' . $_GET['order']; ?><?php if (!empty($_GET['id_categoria'])) echo '&id_categoria=' . $_GET['id_categoria']; ?>">&laquo;</a>
                <?php endif; ?>

                <?php if ($current_page > 2) : ?>
                    <a href="?page=1<?php if (!empty($_GET['search'])) echo '&search=' . $_GET['search']; ?><?php if (!empty($_GET['sort'])) echo '&sort=' . $_GET['sort']; ?><?php if (!empty($_GET['order'])) echo '&order=' . $_GET['order']; ?><?php if (!empty($_GET['id_categoria'])) echo '&id_categoria=' . $_GET['id_categoria']; ?>">1</a>
                <?php endif; ?>

                <?php if ($current_page > 3) : ?>
                    <span>...</span>
                <?php endif; ?>

                <?php for ($i = max(1, $current_page - 1); $i <= min($totalPaginas, $current_page + 1); $i++) : ?>
                    <a href="?page=<?php echo $i; ?><?php if (!empty($_GET['search'])) echo '&search=' . $_GET['search']; ?><?php if (!empty($_GET['sort'])) echo '&sort=' . $_GET['sort']; ?><?php if (!empty($_GET['order'])) echo '&order=' . $_GET['order']; ?><?php if (!empty($_GET['id_categoria'])) echo '&id_categoria=' . $_GET['id_categoria']; ?>" <?php if ($i == $current_page) echo 'class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($current_page < $totalPaginas - 2) : ?>
                    <span>...</span>
                <?php endif; ?>

                <?php if ($current_page < $totalPaginas - 1) : ?>
                    <a href="?page=<?php echo $totalPaginas; ?><?php if (!empty($_GET['search'])) echo '&search=' . $_GET['search']; ?><?php if (!empty($_GET['sort'])) echo '&sort=' . $_GET['sort']; ?><?php if (!empty($_GET['order'])) echo '&order=' . $_GET['order']; ?><?php if (!empty($_GET['id_categoria'])) echo '&id_categoria=' . $_GET['id_categoria']; ?>"><?php echo $totalPaginas; ?></a>
                <?php endif; ?>

                <?php if ($current_page < $totalPaginas) : ?>
                    <a href="?page=<?php echo $current_page + 1; ?><?php if (!empty($_GET['search'])) echo '&search=' . $_GET['search']; ?><?php if (!empty($_GET['sort'])) echo '&sort=' . $_GET['sort']; ?><?php if (!empty($_GET['order'])) echo '&order=' . $_GET['order']; ?><?php if (!empty($_GET['id_categoria'])) echo '&id_categoria=' . $_GET['id_categoria']; ?>">&raquo;</a>
                <?php endif; ?>
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

    <script src="../assests/js/main-productos.js"></script>

</body>

</html>