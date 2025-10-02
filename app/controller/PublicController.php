<?php
// app/controller/PublicController.php

// REQUERIMOS LOS MODELOS NECESARIOS AL INICIO
require_once ROOT_PATH . 'app/model/Offer.php';
require_once ROOT_PATH . 'app/model/NewProduct.php';
require_once ROOT_PATH . 'app/model/Category.php';
require_once ROOT_PATH . 'app/model/Brand.php';
require_once ROOT_PATH . 'app/model/Product.php'; 

class PublicController {
    protected $db; // Asegúrate de tener la conexión a la BD disponible

    private $offerModel;
    private $newProductModel;
    // private $portadaModel;

    public function __construct($connection) {
        $this->db = $connection;
        // Inicializa tus modelos aquí si lo prefieres
        $this->offerModel = new Offer($connection);
        $this->newProductModel = new NewProduct($connection);
    }

    public function index() {
        // --- Cargar datos para el Header ---
        $categoryModel = new Category($this->db);
        $brandModel = new Brand($this->db);
        $categories = $categoryModel->getAll();
        $brands = $brandModel->getAll();
        // --- Fin de Cargar datos para el Header ---

        // Obtener datos para la página de inicio desde los modelos

        // Obtenemos todos los productos
        $productModel = new Product($this->db);
        $products = $productModel->getAll();

        $offers = $this->offerModel->getAll(); // Obtiene todas las ofertas
        $newProducts = $this->newProductModel->getAll(); // Obtiene todos los productos "recién llegados"
        $sliderImagesPath = ROOT_PATH . 'public/assets/uploads/sliderImages/';
        $sliderImages = []; // Inicia la variable como un array vacío
        
        // Verifica si la carpeta existe para evitar errores
        if (is_dir($sliderImagesPath)) {
            // Escanea el directorio y obtiene todos los archivos
            $files = scandir($sliderImagesPath);
            
            // Filtra los resultados para eliminar '.' y '..' que no son imágenes
            $sliderImages = array_diff($files, ['.', '..']);
        }
        
        // $sliderImages = $this->portadaModel->getAll(); // Obtiene las portadas para el slider

        // Incluir la vista de la página de inicio
        include ROOT_PATH . 'app/views/public/home.php';
    }

    public function aboutUs() {
        // --- Cargar datos para el Header (SE REPITE EN CADA MÉTODO) ---
        $categoryModel = new Category($this->db);
        $brandModel = new Brand($this->db);
        $categories = $categoryModel->getAll();
        $brands = $brandModel->getAll();
        // --- Fin de Cargar datos para el Header ---

        include ROOT_PATH . 'app/views/public/about_us.php';
    }
}
?>