<?php
// app/controller/AuthController.php
require_once ROOT_PATH . 'app/model/User.php';

class AuthController {
    private $userModel;

    public function __construct($connection) {
        $this->userModel = new User($connection);
    }

    public function login() {
        $alert = '';
        // Iniciar la sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Si ya hay una sesión activa, redirige al dashboard
        if (!empty($_SESSION['active'])) {
            header('location: /admin/dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['usuario']) || empty($_POST['clave'])) {
                $alert = 'Ingrese su usuario y su clave';
            } else {
                $usuario = $_POST['usuario'];
                $clave = $_POST['clave']; // CORRECCIÓN: Se envía la clave sin encriptar

                $user = $this->userModel->getUserByCredentials($usuario, $clave);

                if ($user) {
                    // Credenciales correctas, se inicia la sesión
                    $_SESSION['active'] = true;
                    // CORRECCIÓN: Se usan los nombres de columna correctos de la BD
                    $_SESSION['idUser'] = $user['id_user']; 
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

        // Carga la vista del formulario de login
        include ROOT_PATH . 'app/views/auth/login.php';
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('location: /auth/login');
        exit;
    }
}
?>