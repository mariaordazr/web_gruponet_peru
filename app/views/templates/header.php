<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/assets/logo/gruponet.webp">
    <title>Corporación Gruponet</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <link rel="stylesheet" href="/assets/css/swiper-bundle.min.css">
    
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>

<header class="main-header" id="header">
    <div class="header-container">
        <div class="header-top">
            <a href="/" class="header-logo">
                <img src="/assets/img/gruponet.png" alt="Logo Gruponet">
            </a>

            <form class="header-search">
                <input type="text" class="header-search__input" placeholder="Buscar productos, marcas y más...">
                <button type="submit" class="header-search__button">
                    <i class='bx bx-search'></i>
                </button>
            </form>
            
            <div class="header-mobile-toggle" id="mobile-menu-button">
                <i class='bx bx-menu'></i>
            </div>
        </div>

        <div class="header-bottom" id="nav-menu">
            <nav class="header-nav">
                <ul class="nav-list">
                    <li class="nav-item nav-item--location">
                        <i class='bx bx-map'></i>
                        <span>Ubicados en<br><b>Lima, Perú</b></span>
                    </li>
                    <li class="nav-item nav-item--dropdown">
                        <a href="#" class="nav-link" data-dropdown-toggle="categories-dropdown">Categorías <i class='bx bx-chevron-down'></i></a>
                        <div id="categories-dropdown" class="dropdown-menu">
                            <ul>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <li><a href="/category/<?php echo $category['id_category']; ?>"><?php echo htmlspecialchars(ucwords(strtolower($category['name']))); ?></a></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="nav-item nav-item--dropdown">
                        <a href="#" class="nav-link" data-dropdown-toggle="brands-dropdown">Marcas <i class='bx bx-chevron-down'></i></a>
                        <div id="brands-dropdown" class="dropdown-menu">
                            <ul>
                                <?php if (!empty($brands)): ?>
                                    <?php foreach ($brands as $brand): ?>
                                        <li><a href="/brand/<?php echo $brand['id_brand']; ?>"><?php echo htmlspecialchars(ucwords(strtolower($brand['name']))); ?></a></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item"><a href="/recien-llegados" class="nav-link">Recién llegados</a></li>
                    <li class="nav-item"><a href="/ofertas" class="nav-link">Ofertas</a></li>
                    <li class="nav-item"><a href="/services" class="nav-link">Servicios</a></li>
                </ul>
            </nav>

            <nav class="header-user-nav">
                <ul class="nav-list">
                    <li class="nav-item"><a href="/about-us" class="nav-link">Nosotros</a></li>
                    <li class="nav-item"><a href="/carrito" class="nav-link"><i class='bx bx-cart'></i> Carrito</a></li>
                    <li class="nav-item"><a href="/auth/login" class="nav-link">Admin</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<main class="main-content">