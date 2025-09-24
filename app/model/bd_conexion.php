<?php 
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "corpora6_bd";

    $conexion = new mysqli($host, $user, $pass, $bd);
    $conexion->set_charset("utf8");  // Corregir aquí
    date_default_timezone_set("America/Lima");

    if (!$conexion){
        echo 'Conexion fallida';
    }
?>
