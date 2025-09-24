<?php
include "model/bd_conexion.php";
$alert = '';

if (isset($_POST['btnAggPort'])) {
    // Verificar si se ha subido una imagen
    if (isset($_FILES['txtimg']) && $_FILES['txtimg']['error'] === UPLOAD_ERR_OK) {
        // Obtener el nombre y extensión del archivo subido
        $fileName = $_FILES['txtimg']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Definir las extensiones permitidas
        $allowedExtensions = array("jpg", "jpeg", "png", "gif", "webp");

        // Verificar si la extensión del archivo está en la lista de extensiones permitidas
        if (in_array(strtolower($fileExtension), $allowedExtensions)) {
            // Incluir el archivo de conexión a la base de datos
            include "model/bd_conexion.php";

            // Obtener los datos de la imagen
            $imgData = file_get_contents($_FILES['txtimg']['tmp_name']);

            // Preparar la consulta para insertar la imagen
            $query = "INSERT INTO portadas (img_portada) VALUES (?)";
            $stmt = mysqli_prepare($conexion, $query);
            mysqli_stmt_bind_param($stmt, 's', $imgData);

            // Ejecutar la consulta
            if (mysqli_stmt_execute($stmt)) {
                // Redirigir a la página de lista de portadas o mostrar un mensaje de éxito
                header('Location: lista_portada.php');
            } else {
                $alert = '<div class="alert">Error al insertar la imagen en la base de datos.</div>';
            }
            mysqli_stmt_close($stmt);
        } else {
            $alert = '<div class="alert">Por favor, selecciona una imagen válida (jpg, jpeg, png, gif) para cargar.</div>';
        }
    } else {
        $alert = '<div class="alert">Por favor, selecciona una imagen válida para cargar.</div>';
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
        <!--================ MODAL AGREGAR ================-->
        <section class="modal">
            <button class="show-modal">Agregar Portada</button>
            <span class="overlay"></span>

            <div class="modal-box">
                <h2>Nueva portada</h2>
                <?php echo isset($alert) ? $alert : ''; ?>

                <div class="container">
                    <div class="img-area" data-img="">
                        <i class='bx bxs-cloud-upload icon'></i>
                        <h3>Upload Image</h3>
                        <p>Image size must be less than <span>2MB</span></p>
                    </div>
                    <button class="select-image">Selecciona Imagen</button>
                </div>

                <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div>
                        <button id="close-modal" class="close-modal" hidden>Cerrar</button>

                        <input type="file" id="file" name="txtimg" accept="image/*" hidden>
                        <div class="buttons">
                            <button type="submit" class="btn_agg" name="btnAggPort" value="OK">Agregar</button>
                        </div>
                    </div>
                </form>
                
            </div>
        </section>

        <section class="table__header">
            <h1>Lista de portadas</h1>
        </section>


        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $query = mysqli_query($conexion, "SELECT * FROM portadas");
                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_array($query)) {

                            # code...
                    ?>
                            <tr>
                                <td><?php echo $data["id_portada"] ?></td>
                                <td><img src="data:image/jpg;base64,<?php echo base64_encode($data['img_portada']); ?>" alt=""></td>
                                <td>
                                    <a class="btn-table_edit" href="editar_portada.php?id=<?php echo $data["id_portada"]; ?>">Editar</a>
                                    <a class="btn-table_delete" href="javascript:void(0);" onclick="confirmDeletePortada(<?php echo $data["id_portada"]; ?>)">Eliminar</a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>


    </main>

    <!--================ MAIN JS ================-->
    <script src="views/js/main-pro.js"></script>

</body>

</html>