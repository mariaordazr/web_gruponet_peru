<?php include ROOT_PATH . 'app/views/templates/header.php'; ?>

<section class="home" id="home">
    <div class="container">
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
    </div>
</section>

<section class="section">
    <div class="container products-container">
        <div class="section-header">
            <h1 class="section__title">Nuestros Productos</h1>
        </div>
        <div class="products-box">
            <div class="swiper product-page-carousel">
                <div class="swiper-wrapper">
                    <?php foreach ($products as $product): ?>
                        <div class="swiper-slide">
                            <a href="/product/<?php echo $product['id_product']; ?>" class=" product-card">
                                <div class="product-card__inner">    
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
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container products-container">
        <div class="section-header">
            <h1 class="section__title">Ofertas</h1>
        </div>
        
        <div class="products-box">
            <div class="swiper product-page-carousel">
                <div class="swiper-wrapper">
                    <?php foreach ($offers as $offer): ?>
                        <div class="swiper-slide">
                            <a href="/offer/<?php echo $offer['product_id']; ?>" class="product-card">
                                <div class="product-card__image">
                                    <img src="/assets/uploads/products/<?php echo htmlspecialchars($offer['file_name']); ?>" alt="<?php echo htmlspecialchars($offer['name']); ?>">
                                </div>
                                <div class="product-card__content">
                                    <p class="product-card__title"><?php echo htmlspecialchars($offer['name']); ?></p>
                                    <div class="product-card__price">
                                        <span class="original-price">S/. <?php echo htmlspecialchars(number_format($offer['original_price'], 2)); ?></span>
                                        <span class="offer-price">S/. <?php echo htmlspecialchars(number_format($offer['offer_price'], 2)); ?></span>
                                        <?php
                                            // Cálculo del porcentaje de descuento
                                            if ($offer['original_price'] > 0) {
                                                $discount = round((($offer['original_price'] - $offer['offer_price']) / $offer['original_price']) * 100);
                                                echo "<span class='offer-card__discount'>-{$discount}%</span>";
                                            }
                                        ?>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="offers-container">
            <div class="section-header">
                <h2 class="section__title">Ofertas</h2>
            </div>
            <div class="swiper product-carousel">
                <div class="swiper-wrapper">
                    <?php foreach ($offers as $offer): ?>
                        <a href="/offer/<?php echo $offer['product_id']; ?>" class="product-card">
                            <div class="product-card__image">
                                <img src="/assets/uploads/products/<?php echo htmlspecialchars($offer['file_name']); ?>">
                            </div>
                            <div class="product-card__content">
                                <p class="product-card__title short"><?php echo htmlspecialchars($offer['name']); ?></p>
                                <div class="product-card__price">
                                    <span class="original-price">S/. <?php echo htmlspecialchars(number_format($offer['original_price'], 2)); ?></span>
                                    <span class="offer-price">S/. <?php echo htmlspecialchars(number_format($offer['offer_price'], 2)); ?></span>
                                    <?php
                                        // Cálculo del porcentaje de descuento
                                        if ($offer['original_price'] > 0) {
                                            $discount = round((($offer['original_price'] - $offer['offer_price']) / $offer['original_price']) * 100);
                                            echo "<span class='offer-card__discount'>-{$discount}%</span>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach;?>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        <!-- </div> -->
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="discover-box">
            <div class="discover-header">
                <h2 class="section__title">Recién Llegados</h2>
                <a href="/offers" class="section-header__link">Ver todas</a>
            </div>
            
            <div class="swiper discover-carousel">
                <div class="swiper-wrapper">
                    <?php foreach ($newProducts as $product): ?>
                        <div class="swiper-slide">
                            <a href="/product/<?php echo $product['id_new_product']; ?>" class="product-card">
                                <div class="product-card__image"><img src="/assets/uploads/products/<?php echo htmlspecialchars($product['file_name']); ?>"></div>
                                <div class="product-card__content">
                                    <p class="product-card__title"><?php echo htmlspecialchars($product['name']); ?></p>
                                    <div class="product-card__price"><span>S/. <?php echo htmlspecialchars(number_format($product['price'], 2)); ?></span></div>
                                    <div class="product-card__shipping">Envío a todo el Perú</div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </div>
</section>

<script src="/assets/js/home.js"></script>

<?php include ROOT_PATH . 'app/views/templates/footer.php'; ?>