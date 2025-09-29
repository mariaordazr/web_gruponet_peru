<?php

// Incluir los modelos necesarios desde la ruta raíz de la aplicación.
require_once ROOT_PATH . 'app/model/Product.php'; 
require_once ROOT_PATH . 'app/model/Category.php'; // Asegúrate de que esta clase exista.
require_once ROOT_PATH . 'app/model/Brand.php'; // Asegúrate de que esta clase exista.

class AdminProductController {
    private $productModel;
    private $categoryModel;
    private $brandModel;

    public function __construct($connection) {
        $this->productModel = new Product($connection);
        $this->categoryModel = new Category($connection);
        $this->brandModel = new Brand($connection);
    }
    
    /**
     * Muestra la lista de productos (lógica de lista_productos.php).
     */
    public function index() {
        // Lógica de paginación y búsqueda.
        $productsPerPage = 20;
        $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $searchTerm = $_GET['search'] ?? '';

        $totalProducts = $this->productModel->getTotalProductsCount($searchTerm);
        $totalPages = ceil($totalProducts / $productsPerPage);
        
        $start = ($currentPage - 1) * $productsPerPage;
        
        // Obtiene los productos del modelo.
        $products = $this->productModel->getAll($searchTerm, $start, $productsPerPage);

        // Incluye la vista para mostrar la tabla de productos.
        include ROOT_PATH . 'app/views/admin/product/list.php';
    }

    /**
     * Maneja la creación del producto (lógica de agregar_producto.php).
     */
    public function create() {
        $alert = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitizar y obtener datos POST.
            $data = $_POST;
            $uploadedFile = $_FILES["image"];

            // Subir imagen y obtener la ruta.
            $imageInfo = $this->handleImageUpload($uploadedFile, 'products');

            if ($imageInfo) {
                // Llamar al modelo para crear el producto.
                if ($this->productModel->create($data, $imageInfo['fileName'], $imageInfo['fileRoute'])) {
                    header("Location: /admin/products");
                    exit;
                } else {
                    $alert = '<div class="alert">Error al agregar el producto en la base de datos.</div>';
                }
            } else {
                $alert = '<div class="alert">La imagen es inválida o falló la subida.</div>';
            }
        }
        
        // Carga los datos de las categorías y marcas para el formulario.
        $categories = $this->categoryModel->getAll();
        $brands = $this->brandModel->getAll();

        // Incluye la vista del formulario.
        include ROOT_PATH . 'app/views/admin/product/create.php';
    }

    /**
     * Maneja la edición y carga del producto (lógica de editar_producto.php).
     */
    public function update() {
        $idProduct = $_REQUEST['id'] ?? null;
        if (!$idProduct) {
            header("Location: /admin/products");
            exit;
        }
        
        $alert = '';
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $_POST;
            $uploadedFile = $_FILES["image"];
            $imageData = null;

            if (isset($uploadedFile) && $uploadedFile["error"] === UPLOAD_ERR_OK) {
                $imageInfo = $this->handleImageUpload($uploadedFile, 'products');
                if ($imageInfo) {
                    $imageData = $imageInfo;
                }
            }

            if ($this->productModel->update((int)$idProduct, $data, $imageData)) {
                header("Location: /admin/products");
                exit;
            } else {
                 $alert = '<div class="alert">Error al modificar el producto.</div>';
            }
        }
        
        // Carga los datos del producto y de los selectores.
        $productData = $this->productModel->getById((int)$idProduct);
        $categories = $this->categoryModel->getAll();
        $brands = $this->brandModel->getAll();
        
        // Incluye la vista del formulario de edición.
        include ROOT_PATH . 'app/views/admin/product/edit.php';
    }

    /**
     * Elimina el producto (lógica de eliminar_producto.php).
     */
    public function delete() {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $idProduct = (int)$_GET['id'];
            
            if ($this->productModel->delete($idProduct)) {
                header("Location: /admin/products");
                exit;
            }
        }
        header("Location: /admin/products?error=delete_failed");
        exit;
    }

    private function handleImageUpload(array $file, string $folder): ?array {
        $uploadDir = ROOT_PATH . 'public/uploads/' . $folder . '/';
        
        if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
            return null;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $extension;
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return [
                'fileName' => $fileName,
                'fileRoute' => 'uploads/' . $folder
            ];
        }

        return null;
    }
}