<?php include_once ROOT_PATH . 'app/views/admin/templates/sidebar.php'; ?>
<header class="main-header-admin">
    <div class="header-admin__greeting">
        <h3>¡Bienvenido de nuevo, <?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Administrador'); ?>!</h3>
        <h2>Dashboard de Productos</h2>
    </div>
    <div class="header-admin__profile">
        <img src="/assets/img/admin-avatar.png" alt="Avatar Admin">
        <span>admin@info.com</span>
    </div>
</header>