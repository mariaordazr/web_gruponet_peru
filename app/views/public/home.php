<?php include ROOT_PATH . 'app/views/templates/header.php'; ?>

<section class="home" id="home">
    <div class="swiper home-slider">
        <div class="swiper-wrapper">
            <?php foreach ($sliderImages as $imageName): ?>
                <div class="swiper-slide">
                    <img src="/assets/uploads/sliderImages/<?php echo htmlspecialchars($imageName); ?>" alt="Slider de Gruponet">
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="swiper-pagination"></div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>
<section class="product-showcase section">
    <div class="container">
        <h2 class="section__title">Recién Llegados</h2>
        
        <div class="product-grid">
            <?php foreach ($newProducts as $product): ?>
                <a href="/product/<?php echo $product['id_new_product']; ?>" class="product-card">
                    <div class="product-card__image">
                        <img src="/assets/uploads/products/<?php echo htmlspecialchars($product['file_name']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>
                    <div class="product-card__content">
                        <p class="product-card__title"><?php echo htmlspecialchars($product['name']); ?></p>
                        <div class="product-card__price">
                            <span>S/. <?php echo htmlspecialchars(number_format($product['price'], 2)); ?></span>
                        </div>
                        <div class="product-card__shipping">
                            Envío a todo el Perú
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="product-showcase section">
    <div class="container">
        <h2 class="section__title">Ofertas</h2>

        <div class="product-grid">
            <?php foreach ($offers as $offer): ?>
                <a href="/offer/<?php echo $offer['product_id']; // Asumiendo que necesitas un ID de producto ?>" class="product-card">
                    <div class="product-card__image">
                        <img src="/assets/uploads/products/<?php echo htmlspecialchars($offer['file_name']); ?>" alt="<?php echo htmlspecialchars($offer['message']); ?>">
                        <span class="product-card__tag">OFERTA</span>
                    </div>
                    <div class="product-card__content">
                        <p class="product-card__title"><?php echo htmlspecialchars($offer['message']); ?></p>
                        <div class="product-card__price">
                            <span>S/. <?php echo htmlspecialchars(number_format($offer['price'], 2)); ?></span>
                        </div>
                         <div class="product-card__shipping">
                            ¡Aprovecha!
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script src="/assets/js/home.js"></script>

<?php include ROOT_PATH . 'app/views/templates/footer.php'; ?>