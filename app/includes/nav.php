<!--================ NAV ================-->
<div class="nav" id="navbar">
    <nav class="nav__container">
        <div>
            <a href="#" class="nav__link nav__logo">
                <i class='bx bxs-disc nav__icon'></i>
                <span class="nav__logo-name"><?php echo $_SESSION['nom']; ?></span>
            </a>
            <div class="nav__list">
                <div class="nav__items">
                    <h3 class="nav__subtitle">primarios</h3>

                    <a href="index.php" class="nav__link active">
                        <i class='bx bx-home nav__icon'></i>
                        <span class="nav__name">Inicio</span>
                    </a>

                    <div class="nav__dropdown">
                        <a href="lista_portada.php" class="nav__link">
                            <i class='bx bx-movie-play nav__icon'></i>
                            <span class="nav__name">Portadas</span>
                        </a>
                    </div>

                    <div class="nav__dropdown">
                        <a href="lista_productos.php" class="nav__link">
                            <i class='bx bx-package nav__icon'></i>
                            <span class="nav__name">Productos</span>
                            <i class='bx bxs-chevron-down nav__icon nav__dropdown-icon'></i>
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a href="lista_productos.php" class="nav__dropdown-item">Lista productos</a>
                                <a href="agregar_producto.php" class="nav__dropdown-item">Agregar productos</a>
                            </div>
                        </div>
                    </div>

                    <div class="nav__dropdown">
                        <a href="lista_promociones.php" class="nav__link">
                            <i class='bx bxs-megaphone nav__icon'></i>
                            <span class="nav__name">Recién llegados</span>
                            <i class='bx bxs-chevron-down nav__icon nav__dropdown-icon'></i>
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a href="lista_promociones.php" class="nav__dropdown-item">Lista llegados</a>
                                <a href="agregar_promociones.php" class="nav__dropdown-item">Agregar llegados</a>
                            </div>
                        </div>
                    </div>

                    <div class="nav__dropdown">
                        <a href="lista_liquidacion.php" class="nav__link">
                            <i class='bx bxs-discount nav__icon'></i>
                            <span class="nav__name">Liquidacion</span>
                            <i class='bx bxs-chevron-down nav__icon nav__dropdown-icon'></i>
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a href="lista_liquidacion.php" class="nav__dropdown-item">Liquidacion</a>
                                <a href="agregar_liquidacion.php" class="nav__dropdown-item">Agregar Liquidacion</a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="nav__items">
                    <h3 class="nav__subtitle">secundarios</h3>

                    <div class="nav__dropdown">
                        <a href="lista_marcas.php" class="nav__link">
                            <i class='bx bx-message-check nav__icon'></i>
                            <span class="nav__name">Marcas</span>
                            <i class='bx bxs-chevron-down nav__icon nav__dropdown-icon'></i>
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a href="lista_marcas.php" class="nav__dropdown-item">Lista de marcas</a>
                                <a href="agregar_marca.php" class="nav__dropdown-item">Agregar marca</a>
                            </div>
                        </div>
                    </div>

                    <div class="nav__dropdown">
                        <a href="lista_categoria.php" class="nav__link">
                            <i class='bx bx-grid-alt nav__icon'></i>
                            <span class="nav__name">Categoria</span>
                            <i class='bx bxs-chevron-down nav__icon nav__dropdown-icon'></i>
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a href="lista_categoria.php" class="nav__dropdown-item">Lista Categoria</a>
                                <a href="agregar_categoria.php" class="nav__dropdown-item">Agregar Categoria</a>
                            </div>
                        </div>
                    </div>

                    <div class="nav__dropdown">
                        <a href="lista_empresas.php" class="nav__link">
                            <i class='bx bx-buildings nav__icon'></i>
                            <span class="nav__name">Empresas</span>
                            <i class='bx bxs-chevron-down nav__icon nav__dropdown-icon'></i>
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a href="lista_empresas.php" class="nav__dropdown-item">Lista Empresas</a>
                                <a href="agregar_empresa.php" class="nav__dropdown-item">Agregar Empresa</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="model/login/cerrarsesion.php" class="nav__link nav__logout nav__icon">
            <i class='bx bx-log-out'></i>
            <span class="nav__name">Log Out</span>
        </a>
    </nav>
</div>