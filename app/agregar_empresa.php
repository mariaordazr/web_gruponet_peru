<?php
include "model/bd_conexion.php";
$alert = '';

if (isset($_POST["btnAgregar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado el campo "name" del formulario
    if (isset($_POST["name"]) && !empty($_POST["name"]) && isset($_POST["ruc"]) && !empty($_POST["ruc"])) {
        $nombreEmpresa = $_POST["name"];
        $rucEmpresa = $_POST["ruc"];

        // Verificar si se ha subido una imagen
        if (isset($_FILES['txtimg']) && $_FILES['txtimg']['error'] === UPLOAD_ERR_OK) {
            // Obtener el nombre y extensión del archivo subido
            $fileName = $_FILES['txtimg']['name'];
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

            // Definir las extensiones permitidas
            $allowedExtensions = array("jpg", "jpeg", "png", "gif");

            // Verificar si la extensión del archivo está en la lista de extensiones permitidas
            if (in_array(strtolower($fileExtension), $allowedExtensions)) {
                // Incluir el archivo de conexión a la base de datos
                include "model/bd_conexion.php";

                // Obtener los datos de la imagen
                $imgData = file_get_contents($_FILES['txtimg']['tmp_name']);

                // Preparar la consulta para insertar la nueva empresa
                $query = "INSERT INTO empresas (nombre_empresa, ruc_empresa, img_empresa) VALUES (?, ?, ?)";
                $stmt = $conexion->prepare($query);

                // Enlazar los parámetros con las variables
                // Verificar si la preparación de la consulta fue exitosa
                if ($stmt) {
                    // Enlazar los parámetros con las variables
                    $stmt->bind_param("sss", $nombreEmpresa, $rucEmpresa, $imgData);

                    if ($stmt->execute()) {
                        // La empresa se ha agregado con éxito
                        $alert = '<div class="alert success">Empresa agregada con éxito.</div>';
                    } else {
                        // Hubo un error al agregar la empresa
                        $alert = '<div class="alert error">Error al agregar la empresa: ' . $stmt->error . '</div>';
                    }
                    $stmt->close();
                } else {
                    // Hubo un error en la preparación de la consulta
                    $alert = '<div class="alert error">Error en la preparación de la consulta: ' . $conexion->error . '</div>';
                }
            } else {
                $alert = '<div class="alert">Por favor, selecciona una imagen válida (jpg, jpeg, png, gif) para cargar.</div>';
            }
        } else {
            $alert = '<div class="alert">Por favor, selecciona una imagen válida para cargar.</div>';
        }
    } else {
        // Si los campos requeridos están vacíos
        $alert = '<div class="alert error">Por favor, ingresa un nombre de empresa y un RUC válidos.</div>';
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
            <h1>Agregar Empresa</h1>
            <?php echo isset($alert) ? $alert : ''; ?>
        </section>

        <form class="form_productos" action="" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <label class="label_title">Nombre de la Empresa</label>
                <input type="text" class="input_form" name="name" placeholder="Nombre">

                <label class="label_title">RUC</label>
                <input type="text" class="input_form" name="ruc" placeholder="RUC">

                <label class="label_title">Imagen</label>
                <input type="file" id="file" name="txtimg" accept="image/*" hidden>
                <div class="container">
                    <div class="img-area" data-img="">
                        <i class='bx bxs-cloud-upload icon'></i>
                        <h3>Upload Image</h3>
                        <p>Image size must be less than <span>2MB</span></p>
                    </div>
                    <button type="button" id="select-image" class="select-image">Selecciona Imagen</button>
                </div>

                <input class="input_form btn" type="submit" name="btnAgregar" value="Agregar">
            </div>
        </form>
    </main>

    <!--================ MAIN JS ================-->
    <script src="../public/assests/admin/js/main-pro.js"></script>

</body>

</html>