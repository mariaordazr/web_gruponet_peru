<?php 
    include("../model/bd_conexion.php");

    $id = $_GET['id'];
    $sql = "DELETE FROM productos WHERE id_producto ='$id'";

    $query = mysqli_query($conexion,$sql);
    if($query === TRUE){
        header("location:../views/productos.php");
    }
?>