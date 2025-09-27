<?php
include "model/bd_conexion.php";
$alert = "";

// Verificar si se proporciono un ID valido
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST["id"];

    // Realiza la consulta para obtener los datos de la marca
    $query = "SELECT * FROM categoria WHERE id_categoria = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id); // 'i' indica que $id es un entero

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            header("Location: lista_categoria.php");
            exit;
        }
    } else {
        header("Location: lista_categoria.php");
        exit;
    }
}

if (isset($_POST['btnEditCategoria'])) {
    $nuevoNombre = $_POST['name'];
    
    //Realizar la consulta para actualizar el nombre de la marca
    $queryEdit= "UPDATE categoria SET name_categoria = ? WHERE id_categoria = ?";
    $stmtEdit = $conexion->prepare($queryEdit);
    $stmtEdit->bind_param("si", $nuevoNombre, $id); // 'si' indica que $nuevoNombre es una cadena, 'i' indica que $id es un entero

    if ($stmtEdit->execute()) {
        header("Location: lista_categoria.php");
    }else{
        $alert = 'Error al Editar la marca.';
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
            <h1>Editar categoria</h1>
            <?php echo isset($alert) ? $alert : ''; ?>
        </section>

        <form class="form_productos" action="" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <label class="label_title">Categoria</label>
                <input type="text" class="input_form" name="name" placeholder="Nombre" value="<?php echo isset($data['name_categoria']) ? $data['name_categoria'] : ''; ?>">
                <div >
                    <a href="lista_marcas.php" class="login__forgot">regresar</a>
                </div>
                <input class="input_form btn" type="submit" name="btnEditCategoria" value="Editar">
            </div>
        </form>

    </main>

    <!--================ MAIN JS ================-->
    <script src="../public/assests/admin/js/main-pro.js"></script>

</body>

</html>