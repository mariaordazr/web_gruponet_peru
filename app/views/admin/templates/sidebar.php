<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/assets/uploads/logo/gruponet.webp">
    <title>Dashboard | Gruponet</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar__header">
                <a href="/admin/dashboard" class="sidebar__logo">
                    <img src="/assets/img/gruponet.webp" alt="Logo Gruponet">
                </a>

                <button class="sidebar__toggle" id="sidebar-toggle" title="Minimizar menú">
                    <i class='bx bx-menu-alt-right'></i>
                </button>
            </div>
            <nav class="sidebar__nav">
                <ul>
                    <li class="nav-item <?php echo (isset($active_menu) && $active_menu == 'dashboard') ? 'active' : ''; ?>">
                        <a href="/admin/dashboard">
                            <i class='bx bxs-dashboard'></i>
                            <span>Inicio</span>
                        </a>
                    </li>
                    <li class="nav-header">ADMINISTRACIÓN</li>
                    <li class="nav-item <?php echo (isset($active_menu) && $active_menu == 'products') ? 'active' : ''; ?>">
                        <a href="/admin/products">
                            <i class='bx bx-shopping-bag'></i>
                            <span>Productos</span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo (isset($active_menu) && $active_menu == 'offers') ? 'active' : ''; ?>">
                        <a href="/admin/offers">
                            <i class='bx bx-gift'></i>
                            <span>Productos en Oferta</span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo (isset($active_menu) && $active_menu == 'new-products') ? 'active' : ''; ?>">
                        <a href="/admin/new-products">
                            <i class='bx bx-star'></i>
                            <span>Recién Llegados</span>
                        </a>
                    </li>
                     <li class="nav-item <?php echo (isset($active_menu) && $active_menu == 'categories') ? 'active' : ''; ?>">
                        <a href="/admin/categories">
                            <i class='bx bx-category'></i>
                            <span>Categorías</span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo (isset($active_menu) && $active_menu == 'brands') ? 'active' : ''; ?>">
                        <a href="/admin/brands">
                            <i class='bx bx-buildings'></i>
                            <span>Marcas</span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo (isset($active_menu) && $active_menu == 'images') ? 'active' : ''; ?>">
                        <a href="/admin/images">
                            <i class='bx bx-image'></i>
                            <span>Imágenes</span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo (isset($active_menu) && $active_menu == 'users') ? 'active' : ''; ?>">
                        <a href="/admin/users">
                            <i class='bx bx-user'></i>
                            <span>Usuarios</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="sidebar__footer">
                <a href="/auth/logout" class="logout-btn">
                    <i class='bx bx-log-out'></i>
                    <span>Cerrar sesión</span>
                </a>
            </div>
        </aside>

        <main class="main-content">
            
