<?php
// app/controller/AdminOfferController.php

require_once ROOT_PATH . 'app/model/Offer.php';
require_once ROOT_PATH . 'app/model/Product.php';

class AdminOfferController
{
    private $offerModel;
    private $productModel;

    public function __construct($connection)
    {
        $this->offerModel = new Offer($connection);
        $this->productModel = new Product($connection);
    }

    /**
     * Muestra la lista de ofertas para un producto específico y maneja las acciones.
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
            if ($this->offerModel->delete($id)) {
                $alert = '<div class="alert success">Oferta eliminada con éxito.</div>';
            } else {
                $alert = '<div class="alert error">Error al eliminar la oferta.</div>';
            }
        }

        $product = $this->productModel->getById($productId);
        $offers = $this->offerModel->getAll((int)$productId);

        include ROOT_PATH . 'app/views/admin/product/offers.php';
    }

    /**
     * Maneja la creación de una nueva oferta.
     */
    public function create()
    {
        $productId = $_GET['product_id'] ?? null;
        if (!$productId) {
            header('Location: /admin/products');
            exit;
        }

        $alert = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'message' => $_POST['message'] ?? '',
                'price' => (float)$_POST['price'] ?? 0
            ];
            
            if (!empty($data['message']) && $data['price'] > 0) {
                if ($this->offerModel->create($data, (int)$productId)) {
                    header('Location: /admin/product/offers?product_id=' . $productId);
                    exit;
                } else {
                    $alert = '<div class="alert error">Error al crear la oferta.</div>';
                }
            } else {
                $alert = '<div class="alert error">Por favor, complete todos los campos.</div>';
            }
        }

        $product = $this->productModel->getById($productId);
        include ROOT_PATH . 'app/views/admin/product/offer_create.php';
    }

    /**
     * Maneja la edición de una oferta.
     */
    public function update()
    {
        $offerId = $_GET['id'] ?? null;
        $productId = $_GET['product_id'] ?? null;
        if (!$offerId || !$productId) {
            header('Location: /admin/products');
            exit;
        }

        $alert = '';
        $offer = $this->offerModel->getById((int)$offerId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'message' => $_POST['message'] ?? '',
                'price' => (float)$_POST['price'] ?? 0
            ];
            
            if (!empty($data['message']) && $data['price'] > 0) {
                if ($this->offerModel->update((int)$offerId, $data)) {
                    header('Location: /admin/product/offers?product_id=' . $productId);
                    exit;
                } else {
                    $alert = '<div class="alert error">Error al actualizar la oferta.</div>';
                }
            } else {
                $alert = '<div class="alert error">Por favor, complete todos los campos.</div>';
            }
        }

        $product = $this->productModel->getById($productId);
        include ROOT_PATH . 'app/views/admin/product/offer_update.php';
    }
}