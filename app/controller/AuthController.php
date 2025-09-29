<?php
// app/controller/AuthController.php
require_once ROOT_PATH . 'app/model/User.php';

class AuthController {
    private $userModel;

    public function __construct($connection) {
        $this->userModel = new User($connection);
    }

    public function login() {
        // ... (Aquí va toda la lógica de login que te mostré antes) ...
        // Comprueba si ya hay sesión, procesa el POST, valida credenciales, etc.
        $alert = '';
        session_start();

        if (!empty($_SESSION['active'])) {
            header('location: /admin/dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = 'Ingrese su usuario y su clave';
            } else {
            // Se llama al método con el nombre correcto y la clave sin encriptar
                $user = $this->userModel->getUserByCredentials($_POST['usuario'], $_POST['clave']);
                if ($user) {
                // Credenciales correctas
                    $_SESSION['active'] = true;
                    $_SESSION['idUser'] = $user['id_user']; // Ajustado al nombre de columna de tu modelo
                    $_SESSION['nombre'] = $user['name'];
                    $_SESSION['user'] = $user['username'];
                    
                    header('location: /admin/dashboard');
                    exit;
                } else {
                    $alert = 'El usuario o la clave son incorrectos';
                    session_destroy();
                }
            }
        }

        include ROOT_PATH . 'app/views/auth/login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('location: /auth/login');
        exit;
    }
}
?>