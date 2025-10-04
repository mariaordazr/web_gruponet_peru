<?php include_once ROOT_PATH . 'app/views/admin/templates/sidebar.php'; ?>
<header class="main-header-admin">
    <div class="header-admin__greeting">
        <h2><?php echo htmlspecialchars($pageTitle ?? 'Gestión de Productos'); ?></h2>
    </div>
    <div class="header-admin__profile">
        <a href="/admin/products/create" class="btn btn-primary">
            <i class='bx bx-plus'></i> Agregar Categoría
        </a>
    </div>
</header>
        <main class="main-content">
            <section class="content-panel">
                <div class="table-container">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Nombre de la Categoría</th>
                                <th>Productos Asociados</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($categories as $category): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                                    <td><?php echo htmlspecialchars($category['product_count']); ?></td>
                                    <td class="actions-cell">
                                        <a href="/admin/categories/edit/<?php echo $category['id_category']; ?>" class="btn-action btn-edit" title="Editar"><i class='bx bxs-edit'></i></a>
                                        <a href="/admin/categories/delete/<?php echo $category['id_category']; ?>" class="btn-action btn-delete" title="Eliminar"><i class='bx bxs-trash'></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
    <script src="/assets/js/admin.js"></script>
</body>
</html>