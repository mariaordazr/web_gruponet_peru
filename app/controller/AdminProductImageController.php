<?php
// app/controller/AdminProductImageController.php

require_once ROOT_PATH . 'app/model/ProductImage.php';
require_once ROOT_PATH . 'app/model/Product.php';

class AdminProductImageController
{
    private $productImageModel;
    private $productModel;

    public function __construct($connection)
    {
        $this->productImageModel = new ProductImage($connection);
        $this->productModel = new Product($connection);
    }

    /**
     * Muestra la lista de imágenes para un producto y maneja las acciones.
     */
    public function index()
    {
        $productId = $_GET['product_id'] ?? null;
        if (!$productId) {
            header('Location: /admin/products');
            exit;
        }

        $alert = '';
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $image = $this->productImageModel->getById($id);
            if ($image) {
                // Lógica para eliminar el archivo físico del disco
                $filePath = ROOT_PATH . 'public/' . $image['file_route'] . '/' . $image['file_name'];
                if (file_exists($filePath) && unlink($filePath)) {
                    if ($this->productImageModel->delete($id)) {
                        $alert = '<div class="alert success">Imagen eliminada con éxito.</div>';
                    } else {
                        $alert = '<div class="alert error">Error al eliminar la referencia de la imagen de la base de datos.</div>';
                    }
                } else {
                    $alert = '<div class="alert error">Error al eliminar el archivo físico.</div>';
                }
            } else {
                $alert = '<div class="alert error">Imagen no encontrada.</div>';
            }
        }

        $product = $this->productModel->getById($productId);
        $images = $this->productImageModel->getAllForProduct((int)$productId);

        include ROOT_PATH . 'app/views/admin/product/images.php';
    }

    /**
     * Maneja la subida y creación de una nueva imagen para un producto.
     */
    public function create()
    {
        $productId = $_GET['product_id'] ?? null;
        if (!$productId) {
            header('Location: /admin/products');
            exit;
        }

        $alert = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $file = $_FILES['image'];
            if ($file['error'] === UPLOAD_ERR_OK) {
                $imageInfo = $this->handleImageUpload($file, 'products');
                if ($imageInfo) {
                    if ($this->productImageModel->create($imageInfo['fileName'], $imageInfo['fileRoute'], (int)$productId)) {
                        header('Location: /admin/product/images?product_id=' . $productId);
                        exit;
                    } else {
                        $alert = '<div class="alert error">Error al asociar la imagen con el producto.</div>';
                    }
                } else {
                    $alert = '<div class="alert error">La subida del archivo falló.</div>';
                }
            } else {
                $alert = '<div class="alert error">Por favor, seleccione un archivo de imagen válido.</div>';
            }
        }
        
        $product = $this->productModel->getById($productId);
        include ROOT_PATH . 'app/views/admin/product/image_create.php';
    }

    /**
     * Maneja la actualización de una imagen.
     */
    public function update()
    {
        $imageId = $_GET['id'] ?? null;
        $productId = $_GET['product_id'] ?? null;
        if (!$imageId || !$productId) {
            header('Location: /admin/products');
            exit;
        }

        $alert = '';
        $image = $this->productImageModel->getById((int)$imageId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $file = $_FILES['image'];
            if ($file['error'] === UPLOAD_ERR_OK) {
                $imageInfo = $this->handleImageUpload($file, 'products');
                if ($imageInfo) {
                    // Opcional: Eliminar el archivo físico anterior
                    $oldFilePath = ROOT_PATH . 'public/' . $image['file_route'] . '/' . $image['file_name'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                    if ($this->productImageModel->update((int)$imageId, $imageInfo['fileName'], $imageInfo['fileRoute'])) {
                        header('Location: /admin/product/images?product_id=' . $productId);
                        exit;
                    } else {
                        $alert = '<div class="alert error">Error al actualizar la imagen en la base de datos.</div>';
                    }
                } else {
                    $alert = '<div class="alert error">La subida del archivo falló.</div>';
                }
            }
        }

        $product = $this->productModel->getById((int)$productId);
        include ROOT_PATH . 'app/views/admin/product/image_update.php';
    }

    private function handleImageUpload(array $file, string $folder): ?array
    {
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