<?php
include "model/bd_conexion.php"; // Se incluye el archivo de conexión a la base de datos
$alert = ''; // Se inicializa una variable para posibles alertas

// Establece la cantidad de productos por página
$productsPerPage = 20;

// Obtiene el número de página actual, si no se proporciona, se establece en 1
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Función que construye una cadena de consulta manteniendo los parámetros de la URL
function getQueryString($additionalParams = [])
{
    // Combina los parámetros GET existentes con los adicionales
    $params = array_merge($_GET, $additionalParams);
    return http_build_query($params);
}

// Función que construye la consulta para obtener los productos
function getProductsQuery($searchTerm = '', $start = 0, $limit = 20)
{
    global $conexion;

    // Consulta base para obtener productos, categorías y marcas
    // Consulta base para obtener productos, categorías y marcas
    $query = "SELECT p.id_producto, p.name_product, c.name_categoria, m.name_marca, p.descripcion, p.precio_product, p.stock_product, p.img_product, p.estado
            FROM productos p
            JOIN categoria c ON p.categoria_id = c.id_categoria
            JOIN marcas m ON p.marca_id = m.id_marca";

    // Agrega condiciones para la búsqueda si hay un término de búsqueda proporcionado
    if (!empty($searchTerm)) {
        $searchTerm = mysqli_real_escape_string($conexion, $searchTerm);
        $query .= " WHERE p.name_product LIKE '%$searchTerm%' OR c.name_categoria LIKE '%$searchTerm%' OR m.name_marca LIKE '%$searchTerm%'";
    }

    // Agrega condición para mostrar solo los productos no agotados

    // Agrega orden y límite a la consulta
    $query .= " ORDER BY p.id_producto LIMIT $start, $limit";
    return $query;
}

// Función que obtiene el total de productos según el término de búsqueda
function getTotalProductsCount($searchTerm = '')
{
    global $conexion;

    // Consulta para obtener el conteo total de productos
    $query = "SELECT COUNT(*) as total FROM productos p JOIN categoria c ON p.categoria_id = c.id_categoria JOIN marcas m ON p.marca_id = m.id_marca";

    // Agrega condiciones para la búsqueda si hay un término de búsqueda proporcionado
    if (!empty($searchTerm)) {
        $searchTerm = mysqli_real_escape_string($conexion, $searchTerm);
        $query .= " WHERE p.name_product LIKE '%$searchTerm%' OR c.name_categoria LIKE '%$searchTerm%' OR m.name_marca LIKE '%$searchTerm%'";
    }

    // Ejecuta la consulta y obtiene el total de productos
    $result = mysqli_query($conexion, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

// Procesar la actualización del estado del producto
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica si hay datos de estado de productos enviados
    if (isset($_POST['id_producto'])) {
        foreach ($_POST['id_producto'] as $idProducto) {
            $estadoCheckbox = 'estado_producto_' . $idProducto;
            $estado = isset($_POST[$estadoCheckbox]) ? 'Activo' : 'Agotado';

            // Actualiza el estado en la base de datos
            $query = "UPDATE productos SET estado = '$estado' WHERE id_producto = $idProducto";

            if (mysqli_query($conexion, $query)) {
                // Éxito al actualizar el estado
                // Puedes añadir algún mensaje de éxito o redireccionar a la misma página
            } else {
                // Error al actualizar el estado
                // Puedes manejar el error como mejor convenga a tu aplicación
            }
        }
    }
}

// Obtiene el total de productos según el término de búsqueda proporcionado
$totalProducts = getTotalProductsCount($_GET['search'] ?? '');

// Calcula el número total de páginas basado en la cantidad de productos por página
$totalPages = ceil($totalProducts / $productsPerPage);

// Verifica y redirige si la página actual excede el número total de páginas
if ($current_page > $totalPages) {
    header("Location: lista_productos.php?page=$totalPages");
    exit;
}

// Verifica y redirige si la página actual es menor que 1
if ($current_page < 1) {
    header("Location: lista_productos.php?page=1");
    exit;
}

// Calcula el índice de inicio para la consulta actual
$start = ($current_page - 1) * $productsPerPage;

// Construye la consulta para obtener los productos con el término de búsqueda, límite y offset
$query = getProductsQuery($_GET['search'] ?? '', $start, $productsPerPage);

// Ejecuta la consulta y obtiene los resultados de productos
$result = mysqli_query($conexion, $query);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include "includes/scripts.php";
    ?>
    <title>Inicio</title>
</head>

<body>
    <?php include("includes/header.php"); ?>

    <!--================ CONTENTS ================-->
    <main class="table">
        <section class="table__header">
            <h1>Lista de productos</h1>
            <form method="GET" action="lista_productos.php" class="header__search">
                <input type="search" name="search" class="header__input" placeholder="Buscar productos">
                <button type="submit"><i class='bx bx-search header__icon'></i></button>
            </form>
        </section>

        <!--================ PAGINACION ================-->
        <div class="pagination">
            <?php if ($current_page > 1) : ?>
                <a href="?page=<?php echo $current_page - 1; ?><?php if (!empty($_GET['search'])) echo '&search=' . $_GET['search']; ?><?php if (!empty($_GET['sort'])) echo '&sort=' . $_GET['sort']; ?><?php if (!empty($_GET['order'])) echo '&order=' . $_GET['order']; ?>">&laquo;</a>
            <?php endif; ?>

            <?php if ($current_page > 2) : ?>
                <a href="?page=1<?php if (!empty($_GET['search'])) echo '&search=' . $_GET['search']; ?><?php if (!empty($_GET['sort'])) echo '&sort=' . $_GET['sort']; ?><?php if (!empty($_GET['order'])) echo '&order=' . $_GET['order']; ?>">1</a>
            <?php endif; ?>

            <?php if ($current_page > 3) : ?>
                <span>...</span>
            <?php endif; ?>

            <?php for ($i = max(1, $current_page - 1); $i <= min($totalPages, $current_page + 1); $i++) : ?>
                <a href="?page=<?php echo $i; ?><?php if (!empty($_GET['search'])) echo '&search=' . $_GET['search']; ?><?php if (!empty($_GET['sort'])) echo '&sort=' . $_GET['sort']; ?><?php if (!empty($_GET['order'])) echo '&order=' . $_GET['order']; ?>" <?php if ($i == $current_page) echo 'class="active"'; ?>><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($current_page < $totalPages - 2) : ?>
                <span>...</span>
            <?php endif; ?>

            <?php if ($current_page < $totalPages - 1) : ?>
                <a href="?page=<?php echo $totalPages; ?><?php if (!empty($_GET['search'])) echo '&search=' . $_GET['search']; ?><?php if (!empty($_GET['sort'])) echo '&sort=' . $_GET['sort']; ?><?php if (!empty($_GET['order'])) echo '&order=' . $_GET['order']; ?>"><?php echo $totalPages; ?></a>
            <?php endif; ?>

            <?php if ($current_page < $totalPages) : ?>
                <a href="?page=<?php echo $current_page + 1; ?><?php if (!empty($_GET['search'])) echo '&search=' . $_GET['search']; ?><?php if (!empty($_GET['sort'])) echo '&sort=' . $_GET['sort']; ?><?php if (!empty($_GET['order'])) echo '&order=' . $_GET['order']; ?>">&raquo;</a>
            <?php endif; ?>
        </div>

        <input type="submit" value="Guardar cambios" class="btn-cambios" form="productForm">

        <section class="table__body">
            <form method="POST" id="productForm">
                <!-- <input type="submit" value="Guardar cambios" class="btn-cambios"> -->
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Marca</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $numRows = mysqli_num_rows($result);

                        if ($numRows > 0) {
                            while ($data = mysqli_fetch_array($result)) {

                        ?>
                                <tr>
                                    <td><?php echo $data["id_producto"] ?></td>
                                    <td><?php echo $data["name_product"] ?></td>
                                    <td><?php echo $data["name_categoria"] ?></td>
                                    <td><?php echo $data["name_marca"] ?></td>
                                    <td><?php echo $data["descripcion"] ?></td>
                                    <td><?php echo $data["estado"] ?></td>
                                    <td>S/.<?php echo $data["precio_product"] ?></td>
                                    <td><?php echo $data["stock_product"] ?></td>
                                    <td><img src="data:image/jpg;base64,<?php echo base64_encode($data['img_product']); ?>" alt="img-producto"></td>
                                    <td>
                                        <!-- Agrega un input hidden para identificar el ID del producto -->
                                        <input type="hidden" name="id_producto[]" value="<?php echo $data["id_producto"]; ?>">
                                        <!-- Utiliza un checkbox para cambiar el estado -->
                                        <input type="checkbox" class="checkbox-agotado" name="estado_producto_<?php echo $data["id_producto"]; ?>" <?php echo $data["estado"] === 'Activo' ? 'checked' : ''; ?>>
                                        <!-- <a class="btn-table_edit" href="editar_producto.php?id=<?php echo $data["id_producto"]; ?>&page=<?php echo $current_page; ?>">Editar</a> -->
                                        <a class="btn-table_edit" href="editar_producto.php?id=<?php echo $data["id_producto"]; ?>"><i class='bx bx-edit-alt'></i></a>
                                        <!-- <a class="btn-table_delete" href="eliminar_producto.php?id=<?php echo $data["id_producto"]; ?>&page=<?php echo $current_page; ?>">Eliminar</a> -->
                                        <a class="btn-table_delete" href="javascript:void(0);" onclick="confirmDelete(<?php echo $data["id_producto"]; ?>)"><i class='bx bx-trash'></i></a>
                                    </td>
                                </tr>

                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>

        </section>
    </main>

    <!--================ MAIN JS ================-->
    <script src="../public/assests/admin/js/main-pro.js"></script>

</body>

</html>