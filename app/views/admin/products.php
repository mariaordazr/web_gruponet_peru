<?php include_once ROOT_PATH . 'app/views/admin/templates/sidebar.php'; ?>

        <main class="main-content">
            <header class="main-header-admin">
                <div class="header-admin__greeting">
                    <h2>Gestión de Productos</h2>
                </div>
                <a href="/admin/products/create" class="btn btn-primary">
                    <i class='bx bx-plus'></i> Agregar Producto
                </a>
            </header>

            <section class="content-panel">
                <div class="filter-bar">
                    <input type="text" class="filter-bar__search" placeholder="Buscar por nombre...">
                    <select class="filter-bar__select">
                        <option value="">Todas las Categorías</option>
                        <?php foreach($categories as $category): ?>
                            <option value="<?php echo $category['id_category']; ?>"><?php echo $category['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select class="filter-bar__select">
                        <option value="">Todas las Marcas</option>
                        <?php foreach($brands as $brand): ?>
                            <option value="<?php echo $brand['id_brand']; ?>"><?php echo $brand['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn">Filtrar</button>
                </div>

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
                                <th>Acciones</th>
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
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['brand_name']); ?></td>
                                    <td>S/. <?php echo htmlspecialchars(number_format($product['price'], 2)); ?></td>
                                    <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                    <td class="actions-cell">
                                        <a href="/admin/products/edit/<?php echo $product['id_product']; ?>" class="btn-action btn-edit" title="Editar"><i class='bx bxs-edit'></i></a>
                                        <a href="/admin/products/delete/<?php echo $product['id_product']; ?>" class="btn-action btn-delete" title="Eliminar"><i class='bx bxs-trash'></i></a>
                                    </td>
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