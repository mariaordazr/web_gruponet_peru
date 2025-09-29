<?php
// app/controller/AdminCategoryController.php

// Incluir el modelo de Category
require_once ROOT_PATH . 'app/model/Category.php';

class AdminCategoryController
{
    private $categoryModel;

    public function __construct($connection)
    {
        $this->categoryModel = new Category($connection);
    }

    /**
     * Muestra la lista de categorías y maneja la eliminación.
     * Corresponde a la lógica de lista_categoria.php
     */
    public function index()
    {
        $alert = '';
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            if ($this->categoryModel->delete($id)) {
                $alert = '<div class="alert success">Categoría eliminada con éxito.</div>';
            } else {
                $alert = '<div class="alert error">Error al eliminar la categoría.</div>';
            }
        }

        $categories = $this->categoryModel->getAll();
        include ROOT_PATH . 'app/views/admin/category/list.php';
    }

    /**
     * Maneja la creación de una nueva categoría.
     * Corresponde a la lógica de agregar_categoria.php
     */
    public function create()
    {
        $alert = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            if (!empty($name)) {
                if ($this->categoryModel->create($name)) {
                    $alert = '<div class="alert success">Categoría agregada con éxito.</div>';
                } else {
                    $alert = '<div class="alert error">Error al agregar la categoría.</div>';
                }
            } else {
                $alert = '<div class="alert error">Por favor, ingresa un nombre de categoría válido.</div>';
            }
        }

        include ROOT_PATH . 'app/views/admin/category/create.php';
    }

    /**
     * Maneja la edición de una categoría.
     * Corresponde a la lógica de editar_categoria.php
     */
    public function edit()
    {
        $alert = '';
        $id = $_REQUEST['id'] ?? null;
        
        if (!$id) {
            header("Location: /admin/categories");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newName = $_POST['name'] ?? '';
            if ($this->categoryModel->update($id, $newName)) {
                header("Location: /admin/categories");
                exit;
            } else {
                $alert = '<div class="alert error">Error al editar la categoría.</div>';
            }
        }

        $category = $this->categoryModel->getById($id);
        if (!$category) {
            header("Location: /admin/categories");
            exit;
        }

        include ROOT_PATH . 'app/views/admin/category/edit.php';
    }
}