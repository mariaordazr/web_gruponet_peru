<?php
// app/views/admin/new_product/create.php
// La variable $products debe ser proporcionada por el controlador.
// La variable $alert debe ser proporcionada por el controlador.
include ROOT_PATH . 'app/views/admin/templates/header.php';
?>
<section class="table__body">
    <h2>Agregar un Producto Existente como Nuevo</h2>
    <form class="form_productos" action="/admin/new_products/create" method="post">
        <div class="input-group">
            <label class="label_title">Producto</label>
            <select class="input_form" name="product_id" required>
                <option selected disabled>Seleccionar Producto</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo htmlspecialchars($product['id_product']); ?>">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input class="input_form btn" type="submit" value="Agregar como Nuevo">
        </div>
    </form>
</section>
<?php include ROOT_PATH . 'app/views/admin/templates/footer.php'; ?>