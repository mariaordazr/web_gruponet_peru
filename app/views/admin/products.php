<?php include_once ROOT_PATH . 'app/views/admin/templates/sidebar.php'; ?>
<header class="main-header-admin">
    <div class="header-admin__greeting">
        <h2><?php echo htmlspecialchars($pageTitle ?? 'Gestión de Productos'); ?></h2>
    </div>
    <div class="header-admin__profile">
        <a href="/admin/products/create" class="btn btn-primary">
            <i class='bx bx-plus'></i> Agregar Producto
        </a>
    </div>
</header>
        <main class="main-content">
            <section class="content-panel view-list">
                <form class="filter-bar" id="filter-form" method="GET">
                    <input type="text" name="search" class="filter-bar__search" placeholder="Buscar por nombre, modelo..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    
                    <select name="category" class="filter-bar__select">
                        <option value="">Todas las Categorías</option>
                        <?php foreach($categories as $category): ?>
                            <option value="<?php echo $category['id_category']; ?>" <?php echo (isset($_GET['category']) && $_GET['category'] == $category['id_category']) ? 'selected' : ''; ?>>
                                <?php echo $category['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <select name="brand" class="filter-bar__select">
                        <option value="">Todas las Marcas</option>
                        <?php foreach($brands as $brand): ?>
                            <option value="<?php echo $brand['id_brand']; ?>" <?php echo (isset($_GET['brand']) && $_GET['brand'] == $brand['id_brand']) ? 'selected' : ''; ?>>
                                <?php echo $brand['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <div class="filter-bar__checkbox">
                        <input type="checkbox" name="out_of_stock" id="out_of_stock" value="1" <?php echo isset($_GET['out_of_stock']) ? 'checked' : ''; ?>>
                        <label for="out_of_stock">Mostrar Agotados</label>
                    </div>
                </form>

                <div class="table-container">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre del Producto</th>
                                <th>Categoría</th>
                                <th>Marca</th>
                                <th>Precio</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($products as $product): ?>
                                <tr>
                                    <td>
                                        <div class="product-table__image">
                                            <img src="/assets/uploads/products/<?php echo htmlspecialchars($product['file_name'] ?? 'default.png'); ?>" alt="">
                                        </div>
                                    </td>
                                    <td>
                                            <?php echo htmlspecialchars($product['name']); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['brand_name']); ?></td>
                                    <td>S/. <?php echo htmlspecialchars(number_format($product['price'], 2)); ?></td>
                                    <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>