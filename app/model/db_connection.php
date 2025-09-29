<?php 
    /**
     * db_connection.php
     * Archivo para establecer la conexión a la base de datos del proyecto.
     * Los parámetros de conexión y la variable principal se definen aquí.
     */

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "gruponet_db"; // ¡CORREGIDO! Conexión a la base de datos nueva

    // Creación de una nueva instancia de mysqli para la conexión
    $connection = new mysqli($host, $user, $pass, $db);

    // Definir la zona horaria para consistencia
    date_default_timezone_set("America/Lima");

    // Verificar si la conexión falló
    if ($connection->connect_error) {
        // En un entorno de desarrollo, mostrar el error.
        // En producción, se debería registrar el error en un archivo de log sin mostrarlo al usuario.
        die("Connection failed: " . $connection->connect_error);
    }
    
    // Establecer el juego de caracteres a utf8mb4 para el soporte de emojis, etc.
    $connection->set_charset("utf8mb4");
    
    // NOTA: Esta variable $connection ahora puede ser pasada a los constructores de los modelos
    // o declarada como global si es necesario en archivos antiguos.
?>