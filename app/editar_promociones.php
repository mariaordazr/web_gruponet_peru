<?php
include "model/bd_conexion.php";
$alert = '';

if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];

    // Realiza una consulta preparada para obtener los datos del producto con el ID proporcionado
    $query = "SELECT * FROM promociones WHERE id_oferta = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id); // 'i' indica que $id es un entero

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            // Puedes mostrar un mensaje de error o redirigir a una página de error si el ID no es válido
            // Por ejemplo, redirigir a una página de error:
            header("Location: lista_promociones.php");
            exit; // Asegura que el script se detenga después de redirigir
        }
    } else {
        // Error al ejecutar la consulta
        // Puedes mostrar un mensaje de error o redirigir a una página de error
        // Por ejemplo, redirigir a una página de error:
        header("Location: lista_promociones.php");
        exit; // Asegura que el script se detenga después de redirigir
    }

    $stmt->close();
    if (isset($_POST["btnEditPro"])) {
        $id = $_POST["id_oferta"];
        $nombreOferta = $_POST["name"];
        $desOferta = $_POST["descripcion"];
        $precioDes = $_POST["pdescuento"];

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
                    $stmt = $conexion->prepare("UPDATE promociones SET nombre_ofert = ?, des_ofert = ?, precio_des = ?, im_oferta = ? WHERE id_oferta = ?");
                    $stmt->bind_param("ssssi", $nombreOferta, $desOferta, $precioDes, $imagen, $id);

                    if ($stmt->execute()) {
                        header("Location: lista_promociones.php");
                    } else {
                        $alert = '<div class="alert">Error al modificar la oferta en la base de datos.</div>';
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
                $stmt = $conexion->prepare("UPDATE promociones SET nombre_ofert = ?, des_ofert = ?, precio_des = ? WHERE id_oferta = ?");
                $stmt->bind_param("sssi", $nombreOferta, $desOferta, $precioDes, $id);

                if ($stmt->execute()) {
                    header("Location: lista_promociones.php");
                } else {
                    $alert = '<div class="alert">Error al modificar la oferta en la base de datos.</div>';
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
            <h1>Editar promociones</h1>
            <?php echo isset($alert) ? $alert : ''; ?>
        </section>

        <form class="form_productos" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_oferta" value="<?php echo isset($data['id_oferta']) ? $data['id_oferta'] : ''; ?>">
            <div class="input-group">
                <label class="label_title">Nombre</label>
                <input type="text" class="input_form" name="name" placeholder="Nombre" value="<?php echo isset($data['nombre_ofert']) ? $data['nombre_ofert'] : ''; ?>" autocomplete="name">

                <label class="label_title">Descripción</label>
                <textarea name="descripcion" class="input_form" id="message" cols="30" rows="8" placeholder="Descripción"><?php echo isset($data['des_ofert']) ? $data['des_ofert'] : ''; ?></textarea>

                <label class="label_title">Precio</label>
                <input type="text" class="input_form" name="pdescuento" placeholder="Precio" value="<?php echo isset($data['precio_des']) ? $data['precio_des'] : ''; ?>">

                <label class="label_title">Imagen del Producto</label>
                <input type="file" id="file" name="txtimg" accept="image/*" hidden>

                <div class="container">
                    <div class="img-area">
                        <img id="preview-image" src="data:image/jpg;base64,<?php echo base64_encode($data['im_oferta']) ?>">
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