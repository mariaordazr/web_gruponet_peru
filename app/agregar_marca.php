<?php
include "model/bd_conexion.php";
$alert = "";

// Procesar el formulario de agregar marca
if (isset($_POST["btnAgregar"])) {
    // Verifica si se ha enviado el campo "name" del formulario de agregar
    if (isset($_POST["name"]) && !empty($_POST["name"])) {
        $nombreMarca = $_POST["name"];

        // Preparar la consulta SQL para insertar la nueva marca
        $insertQuery = "INSERT INTO marcas (name_marca) VALUES (?)";
        $stmt = $conexion->prepare($insertQuery);
        $stmt->bind_param("s", $nombreMarca);

        if ($stmt->execute()) {
            // La marca se ha agregado con éxito
            $alert = '<div class="alert success">Marca agregada con éxito.</div>';
        } else {
            // Hubo un error al agregar la marca
            $alert = '<div class="alert error">Error al agregar la marca.</div>';
        }
    } else {
        // Si el campo "name" del formulario de agregar está vacío
        $alert = '<div class="alert error">Por favor, ingresa un nombre de marca válido.</div>';
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
            <h1>Agregar marca</h1>
            <?php echo isset($alert) ? $alert : ''; ?>
        </section>

        <form class="form_productos" action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="input-group">
                <label class="label_title">Nombre</label>
                <input type="text" class="input_form" name="name" placeholder="Nombre">              
                <input class="input_form btn" type="submit" name="btnAgregar" value="Agregar">
            </div>
        </form>
        
    </main>

    <!--================ MAIN JS ================-->
    <script src="views/js/main-pro.js"></script>

</body>

</html>