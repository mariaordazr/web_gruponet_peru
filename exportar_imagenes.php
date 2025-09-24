<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// SCRIPT PARA EXPORTAR IMÁGENES BLOB DE LA BASE DE DATOS A ARCHIVOS

// --- CONFIGURACIÓN (¡EDITA ESTAS 6 VARIABLES!) ---

// 1. Datos de tu base de datos
$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; // Generalmente vacío en XAMPP
$db_name = 'corpora6_bd'; // Asegúrate de que sea el nombre correcto de tu BD

// 2. Información de la tabla de origen
$nombre_tabla = 'productos';     // La tabla de donde quieres sacar las imágenes
$columna_id   = 'id_producto';       // El nombre de la columna del ID del producto
$nombre_img = 'name_product'; // El nombre de la columna que contiene el nombre de la imagen (opcional)
$columna_blob = 'img_product';       // El nombre de la columna que contiene la imagen (LONGBLOB)

// 3. Información de la carpeta de destino
$carpeta_destino = 'public/uploads/productos/'; // Carpeta donde se guardarán las imágenes
$extension_archivo = '.jpg'; // Extensión para los nuevos archivos (.png, .gif, etc.)
$max_longitud_nombre = 50; // ¡NUEVO! Límite de caracteres para el nombre


// --- FIN DE LA CONFIGURACIÓN ---


// Función para mostrar mensajes
function log_message($message, $type = 'info') {
    $color = '';
    switch ($type) {
        case 'success':
            $color = 'color:green;';
            break;
        case 'error':
            $color = 'color:red;';
            break;
        case 'warning':
            $color = 'color:orange;';
            break;
    }
    echo "<p style='font-family:monospace; margin:2px 0; {$color}'>{$message}</p>";
}

echo "<h1>Iniciando Script de Exportación de Imágenes</h1>";

// 1. Conexión a la base de datos
$conexion = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conexion->connect_error) {
    log_message("Error de conexión: " . $conexion->connect_error, 'error');
    die();
}
log_message("Conexión a la base de datos exitosa.", 'success');

// 2. Verificar si la carpeta de destino existe
if (!is_dir($carpeta_destino)) {
    log_message("La carpeta '{$carpeta_destino}' no existe. Intentando crearla...", 'warning');
    if (!mkdir($carpeta_destino, 0755, true)) {
        log_message("Error: No se pudo crear la carpeta de destino.", 'error');
        die();
    }
    log_message("Carpeta creada exitosamente.", 'success');
}

// 3. Consulta SQL para obtener los IDs y las imágenes
$sql = "SELECT `{$columna_id}`, `{$nombre_img}`, `{$columna_blob}` FROM `{$nombre_tabla}`";
$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    log_message("Se encontraron {$resultado->num_rows} registros en la tabla '{$nombre_tabla}'.");
    $contador_exito = 0;
    $contador_fallo = 0;

    // 4. Recorrer cada fila y guardar la imagen
    while ($fila = $resultado->fetch_assoc()) {
        $id = $fila[$columna_id];
        $name = $fila[$nombre_img];
        $datos_imagen = $fila[$columna_blob];

        if (!empty($datos_imagen)) {
            // Construir el nombre del archivo usando el ID para que sea único
            $nombre_limpio = str_replace(' ', '_', preg_replace('/[^A-Za-z0-9\-\. ]/', '', $name));
            // Paso 2: Limitar la longitud del nombre usando la variable de configuración
            $nombre_truncado = mb_substr($nombre_limpio, 0, $max_longitud_nombre);

            // Paso 3: Construir el nombre de archivo final (minúsculas + extensión)
            $nombre_archivo = strtolower($nombre_truncado) . $extension_archivo;
            $ruta_completa = $carpeta_destino . $nombre_archivo;

            if (file_put_contents($ruta_completa, $datos_imagen)) {
                log_message("ÉXITO: Imagen para ID {$id} guardada como '{$nombre_archivo}'", 'success');
                $contador_exito++;
            } else {
                log_message("ERROR: No se pudo guardar la imagen para ID {$id}.", 'error');
                $contador_fallo++;
            }
        } else {
            log_message("ADVERTENCIA: No hay datos de imagen para ID {$id}.", 'warning');
        }
    }
    echo "<h2>Proceso Finalizado</h2>";
    log_message("Imágenes guardadas correctamente: {$contador_exito}", 'success');
    log_message("Errores al guardar: {$contador_fallo}", 'error');
} else {
    log_message("No se encontraron registros en la tabla '{$nombre_tabla}'.", 'warning');
}

// 5. Cerrar la conexión
$conexion->close();
?>