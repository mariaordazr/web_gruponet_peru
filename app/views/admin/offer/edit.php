<?php 
// Las variables $offerData y $products deben ser proporcionadas por el controlador.
include ROOT_PATH . 'app/views/admin/templates/header.php';
?>
<form class="form_productos" action="/admin/offers/update" method="post">
    <div class="input-group">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($offerData['id_offer']); ?>">
        
        <label class="label_title">Producto</label>
        <select class="input_form" name="product_id" required>
            <?php foreach ($products as $product): ?>
                <option value="<?php echo htmlspecialchars($product['id_product']); ?>" 
                        <?php echo ($product['id_product'] == $offerData['product']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($product['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <label class="label_title">Mensaje de Oferta</label>
        <input type="text" class="input_form" name="message" placeholder="Ej. ¡50% de Descuento!" value="<?php echo htmlspecialchars($offerData['message']); ?>">
        
        <label class="label_title">Precio de Oferta</label>
        <input type="text" class="input_form" name="price" placeholder="S/. 99.99" value="<?php echo htmlspecialchars($offerData['price']); ?>">
        
        <input class="input_form btn" type="submit" value="Actualizar Oferta">
    </div>
</form>
<?php include ROOT_PATH . 'app/views/admin/templates/footer.php'; ?>