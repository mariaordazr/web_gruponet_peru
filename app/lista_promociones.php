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
            <h1>Lista de Recién llegados</h1>
        </section>

        <!-- Mostrar números de página -->


        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $query = mysqli_query($conexion, "SELECT * FROM promociones");
                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_array($query)) {

                            # code...
                    ?>
                            <tr>
                                <td><?php echo $data["id_oferta"] ?></td>
                                <td><?php echo $data["nombre_ofert"] ?></td>
                                <td><?php echo $data["des_ofert"] ?></td>
                                <td>S/.<?php echo $data["precio_des"] ?></td>
                                <td><img src="data:image/jpg;base64,<?php echo base64_encode($data['im_oferta']); ?>" alt=""></td>
                                <td>
                                    <a class="btn-table_edit" href="editar_promociones.php?id=<?php echo $data["id_oferta"]; ?>"><i class='bx bx-edit-alt'></i></a>
                                    <a class="btn-table_delete" href="javascript:void(0);" onclick="confirmDeleteOferta(<?php echo $data["id_oferta"]; ?>)"><i class='bx bx-trash'></i></a>
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
    <script src="../public/assests/admin/js/main-pro.js"></script>

</body>

</html>