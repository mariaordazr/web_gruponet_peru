<?php
include "model/bd_conexion.php";
$alert = '';

// Verifica si se proporcionó un ID válido
if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];

    // Realiza una consulta preparada para obtener los datos de la empresa con el ID proporcionado
    $query = "SELECT * FROM empresas WHERE id_empresa = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id); // 'i' indica que $id es un entero

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            // Puedes mostrar un mensaje de error o redirigir a una página de error si el ID no es válido
            // Por ejemplo, redirigir a una página de error:
            header("Location: lista_empresas.php");
            exit; // Asegura que el script se detenga después de redirigir
        }
    } else {
        // Error al ejecutar la consulta
        // Puedes mostrar un mensaje de error o redirigir a una página de error
        // Por ejemplo, redirigir a una página de error:
        header("Location: lista_empresas.php");
        exit; // Asegura que el script se detenga después de redirigir
    }

    $stmt->close();

    if (isset($_POST["btnEditar"])) {
        $id = $_POST["id_empresa"];
        $nombreEmpresa = $_POST["name"];
        $rucEmpresa = $_POST["ruc"];

        // Verifica si se proporcionó un archivo válido
        if (isset($_FILES["txtimg"]) && $_FILES["txtimg"]["error"] === UPLOAD_ERR_OK) {
            // Obtiene el contenido del archivo
            $fileExtension = pathinfo($_FILES["txtimg"]["name"], PATHINFO_EXTENSION);
            $allowedExtensions = array("jpg", "jpeg", "png", "gif");

            if (in_array(strtolower($fileExtension), $allowedExtensions)) {
                // Obtiene el contenido del archivo
                $imagen = file_get_contents($_FILES["txtimg"]["tmp_name"]);

                try {
                    // Actualiza la empresa en la base de datos utilizando una consulta preparada
                    $stmt = $conexion->prepare("UPDATE empresas SET nombre_empresa = ?, ruc_empresa = ?, img_empresa = ? WHERE id_empresa = ?");
                    $stmt->bind_param("sssi", $nombreEmpresa, $rucEmpresa, $imagen, $id);

                    if ($stmt->execute()) {
                        header("Location: lista_empresas.php");
                    } else {
                        $alert = '<div class="alert">Error al modificar la empresa en la base de datos.</div>';
                    }

                    $stmt->close();
                } catch (Exception $e) {
                    $alert = '<div class="alert">Error interno en el servidor. Por favor, intenta nuevamente más tarde.</div>';
                }
            } else {
                $alert = '<div class="alert">Selecciona una imagen válida (jpg, jpeg, png, gif).</div>';
            }
        } else {
            // Si no se proporcionó un archivo nuevo, actualiza la empresa sin modificar la imagen
            try {
                // Actualiza la empresa en la base de datos utilizando una consulta preparada
                $stmt = $conexion->prepare("UPDATE empresas SET nombre_empresa = ?, ruc_empresa = ? WHERE id_empresa = ?");
                $stmt->bind_param("ssi", $nombreEmpresa, $rucEmpresa, $id);

                if ($stmt->execute()) {
                    header("Location: lista_empresas.php");
                } else {
                    $alert = '<div class="alert">Error al modificar la empresa en la base de datos.</div>';
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
            <h1>Editar Empresa</h1>
            <?php echo isset($alert) ? $alert : ''; ?>
        </section>

        <form class="form_productos" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_empresa" value="<?php echo $data['id_empresa']; ?>">
            <div class="input-group">
                <label class="label_title">Nombre de la Empresa</label>
                <input type="text" class="input_form" name="name" placeholder="Nombre" value="<?php echo isset($data['nombre_empresa']) ? $data['nombre_empresa'] : ''; ?>">

                <label class="label_title">RUC</label>
                <input type="text" class="input_form" name="ruc" placeholder="RUC" value="<?php echo isset($data['ruc_empresa']) ? $data['ruc_empresa'] : ''; ?>">

                <label class="label_title">Imagen</label>
                <input type="file" id="file" name="txtimg" accept="image/*" hidden>

                <div class="container">
                    <div class="img-area">
                        <img id="preview-image" src="data:image/jpg;base64,<?php echo base64_encode($data["img_empresa"]) ?>">
                        <i class='bx bxs-cloud-upload icon'></i>
                        <h3>Upload Image</h3>
                        <p>Image size must be less than <span>2MB</span></p>
                    </div>
                    <button type="button" class="select-image">Selecciona Imagen</button>

                </div>

                <input class="input_form btn" type="submit" name="btnEditar" value="Editar">
            </div>
        </form>
    </main>

    <!--================ MAIN JS ================-->
    <script src="../public/assests/admin/js/main-pro.js"></script>

</body>

</html>