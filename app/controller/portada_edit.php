<?php
include "../model/bd_conexion.php";
$alert = '';

if (isset($_POST["btnEditPort"])) {
    $id = $_POST["id_portada"];

    // Verifica si se proporcionó un archivo válido
    if (isset($_FILES["txtimg"]) && $_FILES["txtimg"]["error"] === UPLOAD_ERR_OK) {
        // Obtiene el contenido del archivo
        $imagen = addslashes(file_get_contents($_FILES["txtimg"]["tmp_name"]));

        // Actualiza la imagen en la base de datos
        $sql = $conexion->query("UPDATE portadas SET img_portada='$imagen' WHERE id_portada=$id");

        if ($sql == true) {
            header("Location: ../lista_portada.php");
            echo "<div class='alert alert-success'>Imagen editada correctamente</div>";
        } else {
            echo "<div class='alert alert-success'>No se pudo modificar la imagen</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Selecciona una imagen válida</div>";
    }
}
?>
