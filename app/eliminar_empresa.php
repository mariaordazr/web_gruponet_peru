<?php
include "model/bd_conexion.php";

// Inicializa la variable de alerta
$alert = '';

// Verifica si se ha enviado un ID de producto para eliminar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idProducto = $_GET['id'];

    // Consulta SQL para eliminar el producto
    $deleteQuery = "DELETE FROM empresas WHERE id_empresa = ?";
    $stmt = $conexion->prepare($deleteQuery);
    $stmt->bind_param("i", $idProducto);

    if ($stmt->execute()) {
        // Redirige a la página de lista de productos después de la eliminación
        header("Location: lista_empresas.php");
        exit;
    } else {
        // Muestra un mensaje de error si la eliminación falla
        $alert = '<div class="alert">Error al eliminar la empresa.</div>';
    }
}
?>
