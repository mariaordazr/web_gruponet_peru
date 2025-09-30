<?php
// app/controller/PublicController.php

require_once ROOT_PATH . 'app/model/Offer.php';
require_once ROOT_PATH . 'app/model/NewProduct.php';
// require_once ROOT_PATH . 'app/model/Portada.php'; // Se asume que tienes un modelo para las portadas

class PublicController {
    private $offerModel;
    private $newProductModel;
    // private $portadaModel;

    public function __construct($connection) {
        $this->offerModel = new Offer($connection);
        $this->newProductModel = new NewProduct($connection);
        // $this->portadaModel = new Portada($connection);
    }

    public function index() {
        // Obtener datos para la página de inicio desde los modelos
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
        include ROOT_PATH . 'app/views/public/about_us.php';
    }
}
?>