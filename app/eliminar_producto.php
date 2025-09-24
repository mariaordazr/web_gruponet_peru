<?php
include "model/bd_conexion.php";

// Inicializa la variable de alerta
$alert = '';

// Verifica si se ha enviado un ID de producto para eliminar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idProducto = $_GET['id'];

    // Consulta SQL para eliminar el producto
    $deleteQuery = "DELETE FROM productos WHERE id_producto = ?";
    $stmt = $conexion->prepare($deleteQuery);
    $stmt->bind_param("i", $idProducto);

    if ($stmt->execute()) {
        // Redirige a la página de lista de productos después de la eliminación
        header("Location: lista_productos.php");
        exit;
    } else {
        // Muestra un mensaje de error si la eliminación falla
        $alert = '<div class="alert">Error al eliminar el producto.</div>';
    }
}
?>
