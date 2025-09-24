<?php
include "model/bd_conexion.php"; // Incluye el archivo de conexión a la base de datos
$alert = '';

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Preparar una consulta para eliminar la portada con el ID proporcionado
    $query = "DELETE FROM marcas WHERE id_marca = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    if (mysqli_stmt_execute($stmt)) {
        // La portada se eliminó correctamente, puedes redirigir a la página de lista de portadas o mostrar un mensaje de éxito
        header("Location: lista_marcas.php");
    } else {
        // Ocurrió un error al eliminar la portada, puedes mostrar un mensaje de error o redirigir a una página de error
        $alert= "Error al eliminar la portada: " . mysqli_error($conexion);
    }
    mysqli_stmt_close($stmt);
} else {
    // Si no se proporciona un ID, puedes mostrar un mensaje de error o redirigir a una página de error
    $alert = 'ID de portada no proporcionado.';
}
?>
