<?php 
// La variable $categories debe ser proporcionada por el controlador AdminCategoryController.
include ROOT_PATH . 'app/views/admin/templates/header.php';
?>
<section class="table__body">
    <a href="/admin/categories/create" class="btn-table_edit">Agregar Categoría</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($category['id_category']); ?></td>
                        <td><?php echo htmlspecialchars($category['name']); ?></td>
                        <td>
                            <a class="btn-table_edit" href="/admin/categories/edit?id=<?php echo htmlspecialchars($category['id_category']); ?>"><i class='bx bx-edit-alt'></i></a>
                            <a class="btn-table_delete" href="/admin/categories/delete?id=<?php echo htmlspecialchars($category['id_category']); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');"><i class='bx bx-trash'></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay categorías registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
<?php include ROOT_PATH . 'app/views/admin/templates/footer.php'; ?>