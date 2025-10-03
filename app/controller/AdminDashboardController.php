<?php
// app/controller/AdminDashboardController.php

// Asegúrate de incluir aquí los modelos que necesites para el dashboard
// Por ejemplo, un modelo para obtener estadísticas de productos/ventas
// require_once ROOT_PATH . 'app/model/Product.php';
// require_once ROOT_PATH . 'app/model/Order.php'; // Si tienes un modelo de órdenes/ventas

class AdminDashboardController {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
        // Iniciar la sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Verificar si el usuario está logueado, si no, redirigir al login
        if (empty($_SESSION['active'])) {
            header('location: /auth/login');
            exit;
        }
    }

    public function dashboard() {
        $active_menu = 'dashboard'; // Para resaltar el elemento correcto en la sidebar

        // --- DATOS DE EJEMPLO PARA EL DASHBOARD (Reemplazar con datos reales de la BD) ---
        $totalRevenue = 256789;
        $revenueTrend = 27; // % de cambio
        $totalTransactions = 3789;
        $transactionsTrend = 7;
        $availableProducts = 23789;
        $productsTrend = 3;
        // --- FIN DATOS DE EJEMPLO ---

        // Puedes añadir aquí lógica para obtener datos reales:
        // $productModel = new Product($this->db);
        // $totalProducts = $productModel->countAllProducts();
        // $latestOrders = $orderModel->getLatestOrders(5); etc.

        include ROOT_PATH . 'app/views/admin/dashboard.php';
    }

    // Métodos para las otras secciones de administración
    // En app/controller/AdminController.php
    public function products() {
        $active_menu = 'products';

        // Cargar los modelos necesarios
        $productModel = new Product($this->db);
        $categoryModel = new Category($this->db);
        $brandModel = new Brand($this->db);

        // Obtener los datos
        $products = $productModel->getAll();
        $categories = $categoryModel->getAll();
        $brands = $brandModel->getAll();

        // Cargar la vista y pasarle los datos
        include ROOT_PATH . 'app/views/admin/products.php';
    }

    public function offers() {
        $active_menu = 'offers';
        // Lógica para gestionar productos en oferta
        include ROOT_PATH . 'app/views/admin/offers.php';
    }
    
    public function newProducts() {
        $active_menu = 'new-products';
        // Lógica para gestionar productos recién llegados
        include ROOT_PATH . 'app/views/admin/new-products.php';
    }

    public function categories() {
        $active_menu = 'categories';
        // Lógica para gestionar categorías
        include ROOT_PATH . 'app/views/admin/categories.php';
    }

    public function brands() {
        $active_menu = 'brands';
        // Lógica para gestionar marcas
        include ROOT_PATH . 'app/views/admin/brands.php';
    }

    public function images() {
        $active_menu = 'images';
        // Lógica para gestionar imágenes (subida, eliminación, etc.)
        include ROOT_PATH . 'app/views/admin/images.php';
    }

    public function users() {
        $active_menu = 'users';
        // Lógica para gestionar usuarios
        include ROOT_PATH . 'app/views/admin/users.php';
    }
}
?>