<?php

$alert = '';
session_start();

if (!empty($_SESSION['active'])) {
    header('location: index.php');
} else {
    if (!empty($_POST)) {
        if (empty($_POST['user']) || empty($_POST['clave'])) {
            $alert = "Ingrese su usuario y su clave";
        } else {
            require_once "model/bd_conexion.php";

            $user = mysqli_real_escape_string($conexion, $_POST['user']);
            $pass = md5(mysqli_real_escape_string($conexion, $_POST['clave']));

            $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE username= '$user' AND password = '$pass'");
            $result = mysqli_num_rows($query);

            if ($result > 0) {
                $data = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $data['id_usuario'];
                $_SESSION['nom'] = $data['name_user'];
                $_SESSION['user']  = $data['username'];
                $_SESSION['pass']  = $data['password'];

                header('location: index.php');
            } else {
                $alert = 'El usuario o la clave son incorrectos';
                session_destroy();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ======= CSS ======= -->
    <link rel="stylesheet" href="../public/assests/admin/css/login.css">

    <!-- ======= BOX ICONS ======= -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <title>Administrador</title>
</head>

<body>
    <div class="login">
        <div class="login__content">
            <div class="login__img">
                <img src="../public/assests/admin/img/img-login.svg" alt="">
            </div>

            <div class="login__forms">
                <form action="" class="login__registre" id="login-in" method="post">


                    <h1 class="login__title">Iniciar Sesion</h1>

                    <div class="login__box">
                        <i class='bx bx-user login__icon'></i>
                        <input type="text" placeholder="Usuario" name="user" class="login__input">
                    </div>

                    <div class="login__box">
                        <i class='bx bx-lock login__icon'></i>
                        <input type="password" placeholder="Contraseña" name="clave" class="login__input">
                    </div>

                    <div class="login__forgot"><?php echo isset($alert) ? $alert : ''; ?></div>

                    <button type="submit" class="login__button">Ingresar</button>

                    <div>
                        <span class="login__account">Soporte</span>
                        <span class="login__signin" id="sign-up">Sign Up</span>
                    </div>
                </form>
            </div>
        </div>
    </div>



</body>

</html>