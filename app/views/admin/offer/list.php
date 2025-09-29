<?php 
// La variable $offers debe ser proporcionada por el controlador AdminOfferController.
include ROOT_PATH . 'app/views/admin/templates/header.php';
?>
<section class="table__body">
    <a href="/admin/offers/create" class="btn-table_edit">Agregar Oferta</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Mensaje</th>
                <th>Precio</th>
                <th>Producto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($offers)): ?>
                <?php foreach ($offers as $offer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($offer['id_offer']); ?></td>
                        <td><?php echo htmlspecialchars($offer['message']); ?></td>
                        <td>S/.<?php echo htmlspecialchars($offer['price']); ?></td>
                        <td><?php echo htmlspecialchars($offer['product_name']); ?></td>
                        <td>
                            <a class="btn-table_edit" href="/admin/offers/edit?id=<?php echo htmlspecialchars($offer['id_offer']); ?>"><i class='bx bx-edit-alt'></i></a>
                            <a class="btn-table_delete" href="/admin/offers/delete?id=<?php echo htmlspecialchars($offer['id_offer']); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta oferta?');"><i class='bx bx-trash'></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay ofertas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
<?php include ROOT_PATH . 'app/views/admin/templates/footer.php'; ?>