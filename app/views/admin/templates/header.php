<?php
// app/views/admin/templates/header.php
// Este archivo contiene la parte superior del HTML y la navegación.

// Se asume que ROOT_PATH está definido en public/index.php
// y que la variable de alerta ($alert) es pasada por el controlador.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/admin/css/style-pro.css">
    <title>Administrador de Productos</title>
</head>
<body>
    <header class="header">
        <a href="#" class="header__logo">
            <img src="/public/assets/img/logo.png" alt="Logo de la empresa">
        </a>
        <nav class="header__nav">
            <ul class="nav__list">
                <li class="nav__item"><a href="/admin/products" class="nav__link">Productos</a></li>
                <li class="nav__item"><a href="/admin/categories" class="nav__link">Categorías</a></li>
                <li class="nav__item"><a href="/admin/brands" class="nav__link">Marcas</a></li>
                <li class="nav__item"><a href="/admin/new_products" class="nav__link">Nuevos</a></li>
                <li class="nav__item"><a href="/admin/offers" class="nav__link">Ofertas</a></li>
            </ul>
        </nav>
    </header>
    <main class="table_agregar">
        <section class="table__header">
            <h1><?php echo $title ?? 'Administración'; ?></h1>
            <?php echo $alert ?? ''; ?>
        </section>