<?php 
    include("../model/bd_conexion.php");

    $id = $_GET['id'];
    $sql = "DELETE FROM promociones WHERE id_oferta ='$id'";

    $query = mysqli_query($conexion,$sql);
    if($query === TRUE){
        header("location:../views/promocion.php");
    }
?>