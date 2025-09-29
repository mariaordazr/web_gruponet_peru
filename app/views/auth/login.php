<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | Administración</title>
    <link rel="stylesheet" href="/public/assets/admin/css/login.css"> </head>
<body>
    <section id="container">
        <form action="/auth/login" method="post">
            <h3>Iniciar Sesión</h3>
            <img src="/public/assets/img/logo.png" alt="Logo"> <input type="text" name="usuario" placeholder="Usuario">
            <input type="password" name="clave" placeholder="Contraseña">
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <input type="submit" value="INGRESAR">
        </form>
    </section>
</body>
</html>