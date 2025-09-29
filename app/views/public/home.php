<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GRUPONET</title>
</head>
<body>
    <header class="header" id="header">
        <nav class="nav container">
            <div class="nav__btns">
                <a href="/auth/login" class="nav__shop">
                    <i class='bx bx-user'></i>
                </a>
                </div>
        </nav>
    </header>
    <main class="main">
        <section class="home" id="home">
            <div class="slider">
                <?php foreach ($portadas as $nombreArchivo) { ?>
                    <img src="/assets/uploads/portadas/<?php echo htmlspecialchars($nombreArchivo); ?>" alt="Slider Image" class="home__img active">
                <?php } ?>
            </div>
            </section>
        <section class="products section">
            <h2 class="section__title">RECIÉN LLEGADOS</h2>
            <div class="products__container bd-grid">
                <?php foreach ($productosNuevos as $productoNuevo) { ?>
                    <article class="card">
                        <div class="card__img">
                            <?php
                                // LÍNEA DE DEPURACIÓN: Esto creará un comentario en el HTML para que veas la ruta
                                $rutaImagen = "/" . $productoNuevo['file_route'] . '/' . $productoNuevo['file_name'];
                                echo "";
                            ?>
                            <img src="<?php echo htmlspecialchars($rutaImagen); ?>" alt="">
                        </div>
                        <div class="card__name">
                            <p><?php echo htmlspecialchars($productoNuevo['name']); ?></p>
                        </div>
                        <div class="card__precis">
                            <a target="_self" href="view/productos-recien.php?id=<?php echo $productoNuevo['id_new_product']; ?>" class="card__icon"><ion-icon name="add-circle-outline"></ion-icon></ion-icon></a>
                            <div>
                                <span class="card__preci card__preci--now">S/. <?php echo htmlspecialchars($productoNuevo['price']); ?></span>
                            </div>
                            <a href="https://wa.me/51961146060?text=<?php echo urlencode('Hola, estoy interesado en el producto ' . $productoNuevo['name'] . '.'); ?>" target="_blank" class="card__icon"><ion-icon name="logo-whatsapp"></ion-icon></ion-icon></a>
                        </div>
                    </article>
                <?php } ?>
            </div>
        </section>
        <section class="featured section container" id="featured">
            <h2 class="section__title">liquidación</h2>
            <div class="featured__container grid">
                <?php foreach ($promociones as $promocion) { ?>
                    <article class="featured__card">
                        <span class="featured__tag">Oferta</span>
                        <img src="/<?php echo htmlspecialchars($promocion['file_route'] . '/' . $promocion['file_name']); ?>" alt="" class="featured__img">
                        <div class="featured__data">
                            <h3 class="featured__title"><?php echo htmlspecialchars($promocion['message']); ?></h3>
                            <span class="featured__price">S/. <?php echo htmlspecialchars($promocion['price']); ?></span>
                        </div>
                        <a href="https://wa.me/51961146060?text=<?php echo urlencode('Hola, estoy interesado en la oferta de ' . $promocion['message'] . '.'); ?>" target="_blank">
                            <button class="button featured__button">OFERTA ESPECIAL</button>
                        </a>
                    </article>
                <?php } ?>
            </div>
        </section>
    </main>
    <footer class="footer section">
        </footer>
    </body>
</html>