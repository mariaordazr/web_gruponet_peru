<?php
// public/index.php
// 1. Definir la constante y la conexión
define('ROOT_PATH', dirname(__DIR__) . '/');
require_once ROOT_PATH . 'app/db_connection.php';

// 2. Cargar controladores
require_once ROOT_PATH . 'app/controller/PublicController.php';
// CAMBIO CLAVE: Usamos AdminUserController para la autenticación
require_once ROOT_PATH . 'app/controller/AdminUserController.php'; 
require_once ROOT_PATH . 'app/controller/AdminDashboardController.php';
// ... y todos los demás controladores de admin

// 3. Obtener la URI
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $uri);

// 4. Lógica de enrutamiento
if ($segments[0] === 'auth') {
    // Rutas de autenticación
    // CAMBIO CLAVE: Instanciamos AdminUserController
    $controller = new AuthController($connection); 
    
    if ($segments[1] === 'login') {
        $controller->login();
    } elseif ($segments[1] === 'logout') {
        $controller->logout();
    } else {
        http_response_code(404);
        echo "Página no encontrada.";
    }
} elseif ($segments[0] === 'admin') {
    // Rutas de administración (protegidas)
    session_start();
    if (empty($_SESSION['active'])) {
        header('location: /auth/login');
        exit;
    }
    
    // El resto de la lógica de admin permanece igual...
    $adminControllerName = 'Admin' . ucfirst($segments[1] ?? 'dashboard') . 'Controller';
    $actionName = $segments[2] ?? 'index';
    
    if (class_exists($adminControllerName)) {
        $controller = new $adminControllerName($connection);
        if (method_exists($controller, $actionName)) {
            $params = array_slice($segments, 3);
            call_user_func_array([$controller, $actionName], $params);
        } else {
            http_response_code(404);
            echo "Página no encontrada.";
        }
    } else {
        http_response_code(404);
        echo "Página no encontrada.";
    }

} else {
    // Rutas públicas
    $controller = new PublicController($connection);
    $controller->index();
}

// Cierre de la conexión
$connection->close();
?>