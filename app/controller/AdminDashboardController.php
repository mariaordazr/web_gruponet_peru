<?php
// app/controller/AdminDashboardController.php

// Asegúrate de incluir aquí los modelos que necesites para el dashboard
// Por ejemplo, un modelo para obtener estadísticas de productos/ventas
// require_once ROOT_PATH . 'app/model/Product.php';
// require_once ROOT_PATH . 'app/model/Order.php'; // Si tienes un modelo de órdenes/ventas

class AdminDashboardController {
    private $db;
    private $categoryModel;
    private $brandModel;
    private $productModel;

    public function __construct($connection) {
        $this->db = $connection;
        $this->categoryModel = new Category($this->db);
        $this->brandModel = new Brand($this->db);
        $this->productModel = new Product($this->db);

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

        require_once ROOT_PATH . 'app/model/Product.php';

        $productModel = new Product($this->db);


        // Llamamos a los nuevos métodos del modelo
        $totalProducts = $productModel->countTotalProducts();
        $newArrivals = $productModel->countNewArrivals();
        $outOfStock = $productModel->countOutOfStock();
        $lowStock = $productModel->countLowStock();

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

        // Leer los filtros de la URL (si existen)
        $searchTerm = $_GET['search'] ?? '';
        $categoryId = !empty($_GET['category']) ? (int)$_GET['category'] : null;
        $brandId = !empty($_GET['brand']) ? (int)$_GET['brand'] : null;
        $showOutOfStock = isset($_GET['out_of_stock']);

        // Cargar modelos
        $productModel = new Product($this->db);
        $categoryModel = new Category($this->db);
        $brandModel = new Brand($this->db);

        // Obtener datos (pasando los filtros al método getAll)
        $products = $productModel->getAll($searchTerm, $categoryId, $brandId, $showOutOfStock);
        $categories = $categoryModel->getAll();
        $brands = $brandModel->getAll();

        include ROOT_PATH . 'app/views/admin/products.php';
    }

    public function offers() {
        $active_menu = 'offers';
        $pageTitle = 'Productos en Oferta'; // Título para la nueva página

        // Leer los filtros de la URL (igual que en products)
        $searchTerm = $_GET['search'] ?? '';
        $categoryId = !empty($_GET['category']) ? (int)$_GET['category'] : null;
        $brandId = !empty($_GET['brand']) ? (int)$_GET['brand'] : null;
        $showOutOfStock = isset($_GET['out_of_stock']);

        // Cargar modelos
        $offerModel = new Offer($this->db);
        $categoryModel = new Category($this->db);
        $brandModel = new Brand($this->db);

        // Obtener datos usando el NUEVO método y guardarlos en la variable $products
        $products = $offerModel->getOfferedProducts($searchTerm, $categoryId, $brandId, $showOutOfStock);
        $categories = $categoryModel->getAll();
        $brands = $brandModel->getAll();

        // REUTILIZAMOS LA MISMA VISTA
        include ROOT_PATH . 'app/views/admin/products.php';
    }

    public function categories() {
        $active_menu = 'categories';
        $pageTitle = 'Gestión de Categorías';

        // Usamos el nuevo método del modelo
        $categories = $this->categoryModel->getAllWithProductCount();

        // Cargamos la nueva vista que vamos a crear
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

    // En app/controller/AdminController.php

    public function newProducts() {
        $active_menu = 'new-products';
        $pageTitle = 'Productos Recién Llegados'; // Título para la página

        // Leer los filtros de la URL
        $searchTerm = $_GET['search'] ?? '';
        $categoryId = !empty($_GET['category']) ? (int)$_GET['category'] : null;
        $brandId = !empty($_GET['brand']) ? (int)$_GET['brand'] : null;
        $showOutOfStock = isset($_GET['out_of_stock']);

        // Cargar modelos
        // Asegúrate de tener los require_once al inicio del archivo
        $newProductModel = new NewProduct($this->db);
        $categoryModel = new Category($this->db);
        $brandModel = new Brand($this->db);

        // Obtener datos usando el NUEVO método y guardarlos en la variable $products
        $products = $newProductModel->getNewProductsList($searchTerm, $categoryId, $brandId, $showOutOfStock);
        $categories = $categoryModel->getAll();
        $brands = $brandModel->getAll();

        // REUTILIZAMOS LA MISMA VISTA de productos
        include ROOT_PATH . 'app/views/admin/products.php';
    }
}
?>