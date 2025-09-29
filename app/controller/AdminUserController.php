<?php
// app/controller/AdminUserController.php

require_once ROOT_PATH . 'app/model/User.php';

class AdminUserController
{
    private $userModel;

    public function __construct($connection)
    {
        $this->userModel = new User($connection);
    }

    /**
     * Muestra la lista de usuarios.
     */
    public function index()
    {
        $alert = '';
        $users = $this->userModel->getAll();
        include ROOT_PATH . 'app/views/admin/user/list.php';
    }

    /**
     * Maneja la creación de un nuevo usuario.
     */
    public function create()
    {
        $alert = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password']
            ];
            
            if ($this->userModel->create($data)) {
                header('Location: /admin/users');
                exit;
            } else {
                $alert = '<div class="alert error">Error al crear el usuario.</div>';
            }
        }
        include ROOT_PATH . 'app/views/admin/user/create.php';
    }

    /**
     * Maneja la edición de un usuario.
     */
    public function update()
    {
        $alert = '';
        $id = $_REQUEST['id'] ?? null;
        if (!$id) {
            header('Location: /admin/users');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'name' => $_POST['name'],
                'email' => $_POST['email']
            ];
            
            if ($this->userModel->update((int)$id, $data)) {
                header('Location: /admin/users');
                exit;
            } else {
                $alert = '<div class="alert error">Error al actualizar el usuario.</div>';
            }
        }
        
        $userData = $this->userModel->getById((int)$id);
        if (!$userData) {
            header('Location: /admin/users');
            exit;
        }
        include ROOT_PATH . 'app/views/admin/user/edit.php';
    }

    /**
     * Maneja la eliminación de un usuario.
     */
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            if ($this->userModel->delete((int)$id)) {
                header('Location: /admin/users');
                exit;
            }
        }
        header('Location: /admin/users?error=delete_failed');
        exit;
    }
}