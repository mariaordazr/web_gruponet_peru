<?php
include "model/bd_conexion.php";

// Inicializa la variable de alerta
$alert = '';

// Verifica si se ha enviado un ID de producto para eliminar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idProducto = $_GET['id'];

    // Consulta SQL para eliminar el producto
    $deleteQuery = "DELETE FROM promociones WHERE id_oferta = ?";
    $stmt = $conexion->prepare($deleteQuery);
    $stmt->bind_param("i", $idProducto);

    if ($stmt->execute()) {
        // Redirige a la p¨¢gina de lista de productos despu¨¦s de la eliminaci¨®n
        header("Location: lista_promociones.php");
        exit;
    } else {
        // Muestra un mensaje de error si la eliminaci¨®n falla
        $alert = '<div class="alert">Error al eliminar la oferta.</div>';
    }
}
?>
