<?php 
// Las variables $newProducts y $allProducts deben ser proporcionadas por el controlador AdminNewProductController.
include ROOT_PATH . 'app/views/admin/templates/header.php';
?>
<section class="table__body">
    <h1>Productos Nuevos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Producto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($newProducts)): ?>
                <?php foreach ($newProducts as $newProduct): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($newProduct['id_new_product']); ?></td>
                        <td><?php echo htmlspecialchars($newProduct['product_name']); ?></td>
                        <td>
                            <a class="btn-table_delete" href="/admin/new_products/delete?id=<?php echo htmlspecialchars($newProduct['id_new_product']); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto de la lista de nuevos?');"><i class='bx bx-trash'></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay productos marcados como nuevos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <h2>Agregar un Producto Existente como Nuevo</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Producto</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allProducts as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['id_product']); ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td>
                        <a class="btn-table_edit" href="/admin/new_products/add?id=<?php echo htmlspecialchars($product['id_product']); ?>">Agregar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php include ROOT_PATH . 'app/views/admin/templates/footer.php'; ?>