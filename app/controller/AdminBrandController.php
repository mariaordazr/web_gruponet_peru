<?php
// app/controller/AdminBrandController.php

// Incluir el modelo de Brand
require_once ROOT_PATH . 'app/model/Brand.php';

class AdminBrandController
{
    private $brandModel;

    public function __construct($connection)
    {
        $this->brandModel = new Brand($connection);
    }

    /**
     * Muestra la lista de marcas y maneja la eliminación.
     * Corresponde a la lógica de lista_marcas.php y eliminar_marca.php
     */
    public function index()
    {
        $alert = '';
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            if ($this->brandModel->delete($id)) {
                $alert = '<div class="alert success">Marca eliminada con éxito.</div>';
            } else {
                $alert = '<div class="alert error">Error al eliminar la marca.</div>';
            }
        }

        $brands = $this->brandModel->getAll();
        include ROOT_PATH . 'app/views/admin/brand/list.php';
    }

    /**
     * Maneja la creación de una nueva marca.
     * Corresponde a la lógica de agregar_marca.php
     */
    public function create()
    {
        $alert = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            if (!empty($name)) {
                if ($this->brandModel->create($name)) {
                    // Redireccionar o mostrar mensaje de éxito
                    $alert = '<div class="alert success">Marca agregada con éxito.</div>';
                } else {
                    $alert = '<div class="alert error">Error al agregar la marca.</div>';
                }
            } else {
                $alert = '<div class="alert error">Por favor, ingresa un nombre de marca válido.</div>';
            }
        }

        include ROOT_PATH . 'app/views/admin/brand/create.php';
    }

    /**
     * Maneja la edición de una marca.
     * Corresponde a la lógica de editar_marca.php
     */
    public function edit()
    {
        $alert = '';
        $id = $_REQUEST['id'] ?? null;
        
        if (!$id) {
            header("Location: /admin/brands");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newName = $_POST['name'] ?? '';
            if ($this->brandModel->update($id, $newName)) {
                header("Location: /admin/brands");
                exit;
            } else {
                $alert = '<div class="alert error">Error al editar la marca.</div>';
            }
        }

        $brand = $this->brandModel->getById($id);
        if (!$brand) {
            header("Location: /admin/brands");
            exit;
        }

        include ROOT_PATH . 'app/views/admin/brand/edit.php';
    }
}