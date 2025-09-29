<?php
// app/controller/AdminNewProductController.php

require_once ROOT_PATH . 'app/model/NewProduct.php';
require_once ROOT_PATH . 'app/model/Product.php';

class AdminNewProductController
{
    private $newProductModel;
    private $productModel;

    public function __construct($connection)
    {
        $this->newProductModel = new NewProduct($connection);
        $this->productModel = new Product($connection);
    }

    /**
     * Muestra la lista de productos marcados como nuevos y maneja las acciones de agregar/eliminar.
     */
    public function index()
    {
        $alert = '';

        if (isset($_GET['action']) && isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            if ($_GET['action'] === 'add') {
                if ($this->newProductModel->create($id)) {
                    $alert = '<div class="alert success">Producto marcado como nuevo con éxito.</div>';
                } else {
                    $alert = '<div class="alert error">Error al marcar el producto. Podría ya ser nuevo.</div>';
                }
            } elseif ($_GET['action'] === 'delete') {
                if ($this->newProductModel->delete($id)) {
                    $alert = '<div class="alert success">Producto eliminado de la lista de nuevos con éxito.</div>';
                } else {
                    $alert = '<div class="alert error">Error al eliminar la referencia.</div>';
                }
            }
        }
        
        $newProducts = $this->newProductModel->getAll();
        
        // Es útil mostrar también una lista de todos los productos para poder agregar nuevos
        $allProducts = $this->productModel->getAll();

        include ROOT_PATH . 'app/views/admin/product/new_products.php';
    }
}