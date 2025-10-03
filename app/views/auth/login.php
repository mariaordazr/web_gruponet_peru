<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/assets/uploads/logo/gruponet.webp">
    <title>Corporación Gruponet</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <link rel="stylesheet" href="/assets/css/swiper-bundle.min.css">
    
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>

<header class="main-header" id="header">
    <div class="header-container">
        <div class="header-top">

        </div>
    </div>
</header>

<main class="login-page-background">
    <div class="login-container">
        <a href="/" class="login-logo">
            <img src="/assets/img/gruponet.webp" alt="Logo Gruponet">
        </a>
        <div class="login-card">
            <h1>¡Hola! Ingresa a tu cuenta</h1>
            <p class="login-subtitle">Ingresa tu usuario y contraseña.</p>

            <form action="/auth/login" method="POST">
                
                <?php if (!empty($alert)): ?>
                    <div class="alert-error"><?php echo $alert; ?></div>
                <?php endif; ?>

                <div class="input-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>

                <div class="input-group">
                    <label for="clave">Contraseña</label>
                    <input type="password" id="clave" name="clave" required>
                </div>

                <button type="submit" class="btn-submit">Continuar</button>
            </form>

            <div class="login-card__footer">
                <a href="/auth/register" class="create-account-link">Crear cuenta</a>
            </div>
        </div>
    </div>

</main>

<footer class="main-footer">
    <div class="footer-copyright">
        <span>© Gruponet 2025. Todos los derechos reservados.</span>
    </div>
</footer>

</body>
</html>