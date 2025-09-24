<?php
include "model/bd_conexion.php";
$alert = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar y validar los datos del formulario
    $name = ($_POST["name"]);
    $categoria = ($_POST["categoria"]);
    $marca = ($_POST["marca"]);
    $precio = ($_POST["precio"]);
    $stock = ($_POST["stock"]);
    $descripcion = ($_POST["descrip"]);

    // Procesa la imagen
    $imagen = $_FILES["imagen"];
    $imagenTmpName = $imagen["tmp_name"];

    // Verifica si la imagen es válida
    if (getimagesize($imagenTmpName)) {
        // Convierte la imagen a una representación binaria
        $imagenBinaria = file_get_contents($imagenTmpName);

        // Inserta los datos en la base de datos
        $insertQuery = "INSERT INTO productos (name_product, categoria_id, marca_id, descripcion, precio_product, stock_product, img_product) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($insertQuery);
        $stmt->bind_param("siisdss", $name, $categoria, $marca, $descripcion, $precio, $stock, $imagenBinaria);

        if ($stmt->execute()) {
            // echo "Producto agregado con éxito.";
            $alert = '<div class="alert">Producto agregado con éxito.</div>';
            header("Location: lista_productos.php");
        } else {
            echo "Error al agregar el producto: " . $stmt->error;
            $alert = '<div class="alert">Error al agregar el producto: </div>' . $stmt->error;
        }

        $stmt->close();
    } else {
        // echo "La imagen no es válida.";
        $alert = '<div class="alert">La imagen no es válida.</div>';
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
            <h1>Agregar producto</h1>
            <?php echo isset($alert) ? $alert : ''; ?>
        </section>

        <form class="form_productos" action="" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <label class="label_title">Nombre</label>
                <input type="text" class="input_form" name="name" placeholder="Nombre">

                <label class="label_title">Categoría</label>
                <select class="input_form" name="categoria">
                    <option selected disabled>Seleccionar Categoría</option>
                    <?php
                    // Consulta las categorías desde la base de datos
                    $queryCategorias = "SELECT id_categoria, name_categoria FROM categoria";
                    $resultCategorias = mysqli_query($conexion, $queryCategorias);

                    // Itera a través de los resultados y crea opciones para el campo de selección
                    while ($categoria = mysqli_fetch_assoc($resultCategorias)) {
                        echo "<option value='" . $categoria['id_categoria'] . "'>" . $categoria['name_categoria'] . "</option>";
                    }
                    ?>
                </select>

                <label class="label_title">Marca</label>
                <select class="input_form" name="marca">
                    <option selected disabled>Seleccionar Marca</option>
                    <?php
                    // Consulta las marcas desde la base de datos
                    $queryMarcas = "SELECT id_marca, name_marca FROM marcas";
                    $resultMarcas = mysqli_query($conexion, $queryMarcas);

                    // Itera a través de los resultados y crea opciones para el campo de selección
                    while ($marca = mysqli_fetch_assoc($resultMarcas)) {
                        echo "<option value='" . $marca['id_marca'] . "'>" . $marca['name_marca'] . "</option>";
                    }
                    ?>
                </select>


                <label class="label_title">Precio</label>
                <input type="text" class="input_form" name="precio" placeholder="Precio">

                <label class="label_title">Stock</label>
                <input type="text" class="input_form" name="stock" placeholder="Stock">

                <label class="label_title">Descripción</label>
                <textarea name="descrip" class="input_form" id="message" cols="30" rows="5" placeholder="Descripcion"></textarea>

                <label class="label_title">Imagen del Producto</label>
                <div class="container">
                    <input type="file" id="file" name="imagen" accept="image/*" hidden>
                    <div class="img-area" data-img="">
                        <i class='bx bxs-cloud-upload icon'></i>
                        <h3>Upload Image</h3>
                        <p>Image size must be less than <span>2MB</span></p>
                    </div>
                    <button type="button" class="select-image">Selecciona Imagen</button>
                </div>
                <input class="input_form btn" type="submit" value="Enviar">
            </div>
        </form>
        
    </main>

    <!--================ MAIN JS ================-->
    <script src="views/js/main-pro.js"></script>

</body>

</html>