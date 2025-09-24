<?php
include "model/bd_conexion.php";
$catProducto = "";
$marcaProducto = "";
$alert = '';

if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];

    // Realiza una consulta preparada para obtener los datos del producto con el ID proporcionado
    $query = "SELECT * FROM productos WHERE id_producto = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id); // 'i' indica que $id es un entero

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            if (isset($data['marca_id'])) {
                $marcaProducto = $data['marca_id'];
                $catProducto = $data['categoria_id']; // Establece el valor de $marcaProducto si existe en los datos del producto
            }
        } else {
            // Puedes mostrar un mensaje de error o redirigir a una página de error si el ID no es válido
            // Por ejemplo, redirigir a una página de error:
            header("Location: lista_productos.php");
            exit; // Asegura que el script se detenga después de redirigir
        }
    } else {
        // Error al ejecutar la consulta
        // Puedes mostrar un mensaje de error o redirigir a una página de error
        // Por ejemplo, redirigir a una página de error:
        header("Location: lista_productos.php");
        exit; // Asegura que el script se detenga después de redirigir
    }

    $stmt->close();

    if (isset($_POST["btnEditPro"])) {
        $id = $_POST["id_producto"];
        $nombreProducto = $_POST["name"];
        $catProducto = $_POST["categoria"];
        $marcaProducto = $_POST["marca"];
        $precioProducto = $_POST["precio"];
        $stockProducto = $_POST["stock"];
        $descripProducto = $_POST["descrip"];

        // Verifica si se proporcionó un archivo válido
        if (isset($_FILES["txtimg"]) && $_FILES["txtimg"]["error"] === UPLOAD_ERR_OK) {
            // Obtiene el contenido del archivo
            $fileExtension = pathinfo($_FILES["txtimg"]["name"], PATHINFO_EXTENSION);
            $allowedExtensions = array("jpg", "jpeg", "png", "gif", "webp");

            if (in_array(strtolower($fileExtension), $allowedExtensions)) {
                // Obtiene el contenido del archivo
                $imagen = file_get_contents($_FILES["txtimg"]["tmp_name"]);

                try {
                    // Actualiza el producto en la base de datos utilizando una consulta preparada
                    $stmt = $conexion->prepare("UPDATE productos SET name_product = ?, categoria_id = ?, marca_id = ?, descripcion = ?, precio_product = ?, stock_product = ?, img_product = ? WHERE id_producto = ?");
                    $stmt->bind_param("sssssssi", $nombreProducto, $catProducto, $marcaProducto, $descripProducto, $precioProducto, $stockProducto, $imagen, $id);

                    if ($stmt->execute()) {
                        header("Location: lista_productos.php");
                    } else {
                        $alert = '<div class="alert">Error al modificar el producto en la base de datos.</div>';
                    }

                    $stmt->close();
                } catch (Exception $e) {
                    $alert = '<div class="alert">Error interno en el servidor. Por favor, intenta nuevamente más tarde.</div>';
                }
            } else {
                $alert = '<div class="alert">Selecciona una imagen válida (jpg, jpeg, png, gif).</div>';
            }
        } else {
            // Si no se proporcionó un archivo nuevo, actualiza el producto sin modificar la imagen
            try {
                // Actualiza el producto en la base de datos utilizando una consulta preparada
                $stmt = $conexion->prepare("UPDATE productos SET name_product = ?, categoria_id = ?, marca_id = ?, descripcion = ?, precio_product = ?, stock_product = ? WHERE id_producto = ?");
                $stmt->bind_param("ssssssi", $nombreProducto, $catProducto, $marcaProducto, $descripProducto, $precioProducto, $stockProducto, $id);

                if ($stmt->execute()) {
                    header("Location: lista_productos.php");
                } else {
                    $alert = '<div class="alert">Error al modificar el producto en la base de datos.</div>';
                }

                $stmt->close();
            } catch (Exception $e) {
                $alert = '<div class="alert">Error interno en el servidor. Por favor, intenta nuevamente más tarde.</div>';
            }
        }
    }
}
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
    <main class="table_agregar">
        <section class="table__header">
            <h1>Editar producto</h1>
            <?php echo isset($alert) ? $alert : ''; ?>
        </section>

        <form class="form_productos" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_producto" value="<?php echo isset($data['id_producto']) ? $data['id_producto'] : ''; ?>">
            <div class="input-group">
                <label class="label_title">Nombre</label>
                <input type="text" class="input_form" name="name" placeholder="Nombre" value="<?php echo isset($data['name_product']) ? $data['name_product'] : ''; ?>" autocomplete="name">

                <label class="label_title">Categoría</label>
                <select class="input_form" name="categoria">
                    <?php
                    // Consulta las categorías desde la base de datos
                    $queryCategorias = "SELECT id_categoria, name_categoria FROM categoria";
                    $resultCategorias = mysqli_query($conexion, $queryCategorias);

                    // Itera a través de los resultados y crea opciones para el campo de selección
                    while ($rowCategoria = mysqli_fetch_assoc($resultCategorias)) {
                        // Comprueba si la categoría actual coincide con $catProducto
                        if ($rowCategoria['id_categoria'] == $catProducto) {
                            echo "<option value='" . $rowCategoria['id_categoria'] . "' selected>" . $rowCategoria['name_categoria'] . "</option>";
                        } else {
                            echo "<option value='" . $rowCategoria['id_categoria'] . "'>" . $rowCategoria['name_categoria'] . "</option>";
                        }
                    }
                    ?>
                </select>


                <label class="label_title">Marca</label>
                <select class="input_form" name="marca">
                    <?php
                    // Consulta las marcas desde la base de datos
                    $queryMarcas = "SELECT id_marca, name_marca FROM marcas";
                    $resultMarcas = mysqli_query($conexion, $queryMarcas);

                    // Itera a través de los resultados y crea opciones para el campo de selección
                    while ($rowMarca = mysqli_fetch_assoc($resultMarcas)) {
                        $selected = ($rowMarca['id_marca'] == $marcaProducto) ? 'selected' : '';
                        echo "<option value='" . $rowMarca['id_marca'] . "' $selected>" . $rowMarca['name_marca'] . "</option>";
                    }
                    ?>
                </select>

                <label class="label_title">Precio</label>
                <input type="text" class="input_form" name="precio" placeholder="Precio" value="<?php echo isset($data['precio_product']) ? $data['precio_product'] : ''; ?>">

                <label class="label_title">Stock</label>
                <input type="text" class="input_form" name="stock" placeholder="Stock" value="<?php echo isset($data['stock_product']) ? $data['stock_product'] : ''; ?>">

                <label class="label_title">Descripción</label>
                <textarea name="descrip" class="input_form" id="message" cols="30" rows="8" placeholder="Descripcion"><?php echo isset($data['descripcion']) ? $data['descripcion'] : ''; ?></textarea>

                <label class="label_title">Imagen del Producto</label>
                <input type="file" id="file" name="txtimg" accept="image/*" hidden>

                <div class="container">
                    <div class="img-area">
                        <img id="preview-image" src="data:image/jpg;base64,<?php echo base64_encode($data['img_product']) ?>">
                        <!-- <i class='bx bxs-cloud-upload icon'></i>
                    <h3>Upload Image</h3>
                    <p>Image size must be less than <span>2MB</span></p> -->
                    </div>
                    <button type="button" class="select-image">Selecciona Imagen</button>
                </div>

                <input class="input_form btn" type="submit" name="btnEditPro" value="Actualizar">
            </div>
        </form>
    </main>

    <!--================ MAIN JS ================-->
    <script src="views/js/main-pro.js"></script>

</body>

</html>