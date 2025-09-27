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
            <h1>Lista de Categoria</h1>
        </section>

        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $query = mysqli_query($conexion, "SELECT * FROM categoria");
                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_array($query)) {

                            # code...
                    ?>
                            <tr>
                                <td><?php echo $data["id_categoria"] ?></td>
                                <td><?php echo $data["name_categoria"] ?></td>
                                <td>
                                    <a class="btn-table_edit" href="editar_categoria.php?id=<?php echo $data['id_categoria']; ?>"><i class='bx bx-edit-alt'></i></a>
                                    <a class="btn-table_delete" href="javascript:void(0);" onclick="confirmDeleteCategoria(<?php echo $data["id_categoria"]; ?>)"><i class='bx bx-trash'></i></a>
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