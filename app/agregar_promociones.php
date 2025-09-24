<?php
include "model/bd_conexion.php";
$alert = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado el campo "name" del formulario
    if (isset($_POST["name"]) && !empty($_POST["name"]) && isset($_POST["descripcion"]) && !empty($_POST["descripcion"]) && is_numeric($_POST["pdescuento"])) {
        $nombreOferta = mysqli_real_escape_string($conexion, $_POST["name"]);
        $descripOferta = mysqli_real_escape_string($conexion, $_POST["descripcion"]);
        $precioDesc = mysqli_real_escape_string($conexion, $_POST["pdescuento"]);

        // Verificar si se ha subido una imagen
        if (isset($_FILES['txtimg']) && $_FILES['txtimg']['error'] === UPLOAD_ERR_OK) {
            // Obtener el nombre y extensión del archivo subido
            $fileName = $_FILES['txtimg']['name'];
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

            // Definir las extensiones permitidas (incluyendo WebP)
            $allowedExtensions = array("jpg", "jpeg", "png", "gif", "webp");

            // Verificar si la extensión del archivo está en la lista de extensiones permitidas
            if (in_array(strtolower($fileExtension), $allowedExtensions)) {
                // Incluir el archivo de conexión a la base de datos
                include "model/bd_conexion.php";

                // Obtener los datos de la imagen
                $imgData = file_get_contents($_FILES['txtimg']['tmp_name']);

                // Preparar la consulta para insertar la nueva empresa
                $query = "INSERT INTO promociones (nombre_ofert, des_ofert, precio_des, im_oferta) VALUES (?, ?, ?, ?)";
                $stmt = $conexion->prepare($query);

                // Enlazar los parámetros con las variables
                // Verificar si la preparación de la consulta fue exitosa
                if ($stmt) {
                    // Enlazar los parámetros con las variables
                    $stmt->bind_param("ssss", $nombreOferta, $descripOferta, $precioDesc, $imgData);

                    if ($stmt->execute()) {
                        // La empresa se ha agregado con éxito
                        $alert = '<div class="alert success">Oferta agregada con éxito.</div>';
                    } else {
                        // Hubo un error al agregar la empresa
                        $alert = '<div class="alert error">Error al agregar la Oferta: ' . $stmt->error . '</div>';
                    }
                    $stmt->close();
                } else {
                    // Hubo un error en la preparación de la consulta
                    $alert = '<div class="alert error">Error en la preparación de la consulta: ' . $conexion->error . '</div>';
                }
            } else {
                $alert = '<div class="alert">Por favor, selecciona una imagen válida (jpg, jpeg, png, gif, webp) para cargar.</div>';
            }
        } else {
            $alert = '<div class="alert">Por favor, selecciona una imagen válida para cargar.</div>';
        }
    } else {
        // Si los campos requeridos están vacíos
        $alert = '<div class="alert error">Por favor, ingresa valores válidos para nombre, precio normal y precio de descuento.</div>';
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
            <h1>Agregar Recién Llegados</h1>
            <?php echo isset($alert) ? $alert : ''; ?>
        </section>

        <form class="form_productos" action="" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <label class="label_title">Nombre</label>
                <input type="text" class="input_form" name="name" placeholder="Nombre">

                <label class="label_title">Descripción</label>
                <textarea name="descripcion" class="input_form" id="message" cols="30" rows="5" placeholder="Descripcion"></textarea>

                <label class="label_title">Precio</label>
                <input type="text" class="input_form" name="pdescuento" placeholder="Precio">

                <label class="label_title">Imagen</label>
                <input type="file" id="file" name="txtimg" accept="image/*" hidden>
            
                <div class="container">
                    <div class="img-area" data-img="">
                        <i class='bx bxs-cloud-upload icon'></i>
                        <h3>Upload Image</h3>
                        <p>Image size must be less than <span>2MB</span></p>
                    </div>
                    <button type="button" class="select-image">Selecciona Imagen</button>
                </div>

                <input class="input_form btn" type="submit" name="btnAgregar" value="Agregar">
            </div>
        </form>
        
    </main>

    <!--================ MAIN JS ================-->
    <script src="views/js/main-pro.js"></script>

</body>

</html>