<?php 
// La variable $brands debe ser proporcionada por el controlador AdminBrandController.
include ROOT_PATH . 'app/views/admin/templates/header.php';
?>
<section class="table__body">
    <a href="/admin/brands/create" class="btn-table_edit">Agregar Marca</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($brands)): ?>
                <?php foreach ($brands as $brand): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($brand['id_brand']); ?></td>
                        <td><?php echo htmlspecialchars($brand['name']); ?></td>
                        <td>
                            <a class="btn-table_edit" href="/admin/brands/edit?id=<?php echo htmlspecialchars($brand['id_brand']); ?>"><i class='bx bx-edit-alt'></i></a>
                            <a class="btn-table_delete" href="/admin/brands/delete?id=<?php echo htmlspecialchars($brand['id_brand']); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta marca?');"><i class='bx bx-trash'></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay marcas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
<?php include ROOT_PATH . 'app/views/admin/templates/footer.php'; ?>