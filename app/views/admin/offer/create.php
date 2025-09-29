<?php 
// Las variables $products y $alert deben ser proporcionadas por el controlador.
include ROOT_PATH . 'app/views/admin/templates/header.php';
?>
<form class="form_productos" action="/admin/offers/create" method="post">
    <div class="input-group">
        <label class="label_title">Producto</label>
        <select class="input_form" name="product_id" required>
            <option selected disabled>Seleccionar Producto</option>
            <?php foreach ($products as $product): ?>
                <option value="<?php echo htmlspecialchars($product['id_product']); ?>"><?php echo htmlspecialchars($product['name']); ?></option>
            <?php endforeach; ?>
        </select>
        
        <label class="label_title">Mensaje de Oferta</label>
        <input type="text" class="input_form" name="message" placeholder="Ej. ¡50% de Descuento!">
        
        <label class="label_title">Precio de Oferta</label>
        <input type="text" class="input_form" name="price" placeholder="S/. 99.99">
        
        <input class="input_form btn" type="submit" value="Crear Oferta">
    </div>
</form>
<?php include ROOT_PATH . 'app/views/admin/templates/footer.php'; ?>