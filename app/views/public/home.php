<?php include ROOT_PATH . 'app/views/templates/header.php'; ?>

<section class="home" id="home">
    <div class="slider">
        <?php foreach ($sliderImages as $fileName) { ?>
            <img src="/assets/uploads/sliderImages/<?php echo htmlspecialchars($fileName); ?>" alt="Slider Image" class="home__img active">
        <?php } ?>
    </div>

    <div class="home__container container1 grid1">
        <div class="home__data">
            <span class="home__data-subtitle">Bienvenidos</span>
            <h1 class="home__data-title">Corporación <br><b>GRUPONET SAC</b></h1>
            <a href="https://api.whatsapp.com/send/?phone=51961146060&text&type=phone_number&app_absent=0" target="_blank" class="button">Contáctanos</a>
        </div>

        <div class="home__social">
            <a href="https://www.facebook.com/corporaciongruponet" target="_blank" class="home__social-link">
                <i class='bx bxl-facebook-square'></i>
            </a>
            <a href="https://instagram.com/corporaciongruponet?igshid=YmMyMTA2M2Y=" target="_blank" class="home__social-link">
                <i class='bx bxl-instagram-alt'></i>
            </a>
            <a href="https://www.youtube.com/channel/UCahpSqJDrtVHFGCgXSHcpaA" target="_blank" class="home__social-link">
                <i class='bx bxl-youtube'></i>
            </a>
        </div>
    </div>
</section>

<section class="products section">
    <h2 class="section__title">RECIÉN LLEGADOS</h2>
    <div class="products__container bd-grid">
        <?php foreach ($newProducts as $newProduct) { ?>
            <article class="card">
                <div class="card__img">
                    <?php
                        $rutaImagen = "/assets/uploads/products/" . $newProduct['file_name'];
                    ?>
                    <img src="<?php echo htmlspecialchars($rutaImagen); ?>" alt="<?php echo htmlspecialchars($newProduct['name']); ?>">
                </div>
                <div class="card__name">
                    <p><?php echo htmlspecialchars($newProduct['name']); ?></p>
                </div>
                <div class="card__precis">
                    <a target="_self" href="/productos-recien?id=<?php echo $newProduct['id_new_product']; ?>" class="card__icon"><ion-icon name="add-circle-outline"></ion-icon></a>
                    <div>
                        <span class="card__preci card__preci--now">S/. <?php echo htmlspecialchars($newProduct['price']); ?></span>
                    </div>
                    <a href="https://wa.me/51961146060?text=<?php echo urlencode('Hola, estoy interesado en el producto ' . $newProduct['name'] . '.'); ?>" target="_blank" class="card__icon"><ion-icon name="logo-whatsapp"></ion-icon></a>
                </div>
            </article>
        <?php } ?>
    </div>
</section>

<section class="featured section container" id="featured">
    <h2 class="section__title">liquidación</h2>
    <div class="featured__container grid">
        <?php foreach ($offers as $offer) { ?>
            <article class="featured__card">
                <span class="featured__tag">OFERTAS</span>
                <img src="/assets/uploads/products/<?php echo htmlspecialchars($offer['file_name']); ?>" alt="" class="featured__img">
                <div class="featured__data">
                    <h3 class="featured__title"><?php echo htmlspecialchars($offer['message']); ?></h3>
                    <span class="featured__price">S/. <?php echo htmlspecialchars($offer['price']); ?></span>
                </div>
                <a href="https://wa.me/51961146060?text=<?php echo urlencode('Hola, estoy interesado en la oferta de ' . $offer['message'] . '.'); ?>" target="_blank">
                    <button class="button featured__button">OFERTA ESPECIAL</button>
                </a>
            </article>
        <?php } ?>
    </div>
</section>

<script src="/assets/js/home.js"></script>

<?php include ROOT_PATH . 'app/views/templates/footer.php'; ?>