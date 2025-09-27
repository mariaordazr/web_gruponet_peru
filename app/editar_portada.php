<?php
include "model/bd_conexion.php";
$alert = '';

// Verifica si se proporcionó un ID válido
if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];

    // Realiza una consulta preparada para obtener los datos de la portada con el ID proporcionado
    $query = "SELECT * FROM portadas WHERE id_portada = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id); // 'i' indica que $id es un entero

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            // Puedes mostrar un mensaje de error o redirigir a una página de error si el ID no es válido
            // Por ejemplo, redirigir a una página de error:
            header("Location: lista_portada.php");
            exit; // Asegura que el script se detenga después de redirigir
        }
    } else {
        // Error al ejecutar la consulta
        // Puedes mostrar un mensaje de error o redirigir a una página de error
        // Por ejemplo, redirigir a una página de error:
        header("Location: lista_portada.php");
        exit; // Asegura que el script se detenga después de redirigir
    }

    $stmt->close();

    if (isset($_POST["btnEditPort"])) {
        $id = $_POST["id_portada"];

        // Verifica si se proporcionó un archivo válido
        if (isset($_FILES["txtimg"]) && $_FILES["txtimg"]["error"] === UPLOAD_ERR_OK) {
            // Obtiene el contenido del archivo
            $fileExtension = pathinfo($_FILES["txtimg"]["name"], PATHINFO_EXTENSION);
            $allowedExtensions = array("jpg", "jpeg", "png", "gif", "webp");

            if (in_array(strtolower($fileExtension), $allowedExtensions)) {
                // Obtiene el contenido del archivo
                $imagen = file_get_contents($_FILES["txtimg"]["tmp_name"]);

                try {
                    // Actualiza la imagen en la base de datos utilizando una consulta preparada
                    $stmt = $conexion->prepare("UPDATE portadas SET img_portada = ? WHERE id_portada = ?");
                    $stmt->bind_param("si", $imagen, $id);

                    if ($stmt->execute()) {
                        header("Location: lista_portada.php");
                    } else {
                        $alert = '<div class="alert">Error al modificar la imagen en la base de datos.</div>';
                        // echo "<div class='alert alert-danger'>Error al modificar la imagen en la base de datos.</div>";
                    }

                    $stmt->close();
                } catch (Exception $e) {
                    $alert = '<div class="alert">Error interno en el servidor. Por favor, intenta nuevamente más tarde.</div>';
                    // echo "<div class='alert alert-danger'>Error interno en el servidor. Por favor, intenta nuevamente más tarde.</div>";
                }
            } else {
                $alert = '<div class="alert">Selecciona una imagen válida (jpg, jpeg, png, gif).</div>';
                // echo "<div class='alert alert-danger'>Selecciona una imagen válida (jpg, jpeg, png, gif).</div>";
            }
        } else {
            $alert = '<div class="alert">Selecciona una imagen.</div>';
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
    <main class="table">
        <section class="table__header">
            <h1>Editar portada</h1>

        </section>

        <div class="container">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_portada" value="<?php echo $data['id_portada']; ?>">
                <input type="file" id="file" accept="image/*" name="txtimg" hidden>
                <input type="submit" class="btn_edit" name="btnEditPort" value="Actualizar">
                <?php echo $alert; ?>


                <div class="img-area">
                    <img id="preview-image" src="data:image/jpg;base64,<?php echo base64_encode($data["img_portada"]) ?>">
                    <i class='bx bxs-cloud-upload icon'></i>
                    <h3>Upload Image</h3>
                    <p>Image size must be less than <span>2MB</span></p>
                </div>
            </form>
            <button class="select-image">Selecciona Imagen</button>
        </div>
    </main>


    <!--================ MAIN JS ================-->
    <script src="../public/assests/admin/js/main-pro.js"></script>

</body>

</html>