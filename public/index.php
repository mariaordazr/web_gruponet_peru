<?php
// public/index.php

// 1. Activar errores para depuración (puedes quitar esto en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Definir la constante y la conexión
define('ROOT_PATH', dirname(__DIR__) . '/');
require_once ROOT_PATH . 'app/config/db_connection.php';

// 3. Cargar controladores principales
require_once ROOT_PATH . 'app/controller/PublicController.php';
require_once ROOT_PATH . 'app/controller/AuthController.php';
// Incluimos el nuevo AdminController
require_once ROOT_PATH . 'app/controller/AdminDashboardController.php';

// 4. Obtener la URI
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $uri);

// 5. Lógica de enrutamiento
if ($segments[0] === 'auth') {
    // Rutas de autenticación
    $controller = new AuthController($connection);
    $action = $segments[1] ?? 'login';
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        http_response_code(404);
        echo "Página de autenticación no encontrada.";
    }

} elseif ($segments[0] === 'admin') {
    // ================== BLOQUE MODIFICADO ==================
    // Rutas de administración (protegidas)
    $controller = new AdminDashboardController($connection);
    
    // El segundo segmento de la URL es la acción (ej. /admin/dashboard -> 'dashboard')
    $action = $segments[1] ?? 'dashboard'; // Si no hay acción, por defecto es 'dashboard'

    // Convertimos la ruta de kebab-case (ej. new-products) a camelCase (ej. newProducts)
    $action = lcfirst(str_replace('-', '', ucwords($action, '-')));


    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        http_response_code(404);
        echo "Sección de administración no encontrada.";
    }
    // ================== FIN DEL BLOQUE MODIFICADO ==================

} elseif ($segments[0] === 'about-us') {
    // Rutas públicas
    $controller = new PublicController($connection);
    $controller->aboutUs();

} else {
    // Ruta principal (homepage)
    $controller = new PublicController($connection);
    $controller->index();
}

// Cierre de la conexión
if (isset($connection)) {
    $connection->close();
}
?>