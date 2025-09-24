<?php
include "model/bd_conexion.php";
$alert = '';


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
            <h1>Lista de Liquidacion</h1>
        </section>

        <!-- Mostrar números de página -->


        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $query = mysqli_query($conexion, "SELECT * FROM nuevo_liquidaccion");
                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_array($query)) {

                            # code...
                    ?>
                            <tr>
                                <td><?php echo $data["id_nuevo"] ?></td>
                                <td><?php echo $data["nombre_nuevo"] ?></td>
                                <td><?php echo $data["precio_product"] ?></td>
                                <td><img src="data:image/jpg;base64,<?php echo base64_encode($data['img_nuevo']); ?>" alt=""></td>
                                <td>
                                    <a class="btn-table_edit" href="editar_liquidacion.php?id=<?php echo $data["id_nuevo"]; ?>"><i class='bx bx-edit-alt'></i></a>
                                    <a class="btn-table_delete" href="javascript:void(0);" onclick="confirmDeleteLiqui(<?php echo $data["id_nuevo"]; ?>)"><i class='bx bx-trash'></i></a>
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