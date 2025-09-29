<?php 
// Las variables $productData, $images y $alert deben ser proporcionadas por el controlador AdminProductImageController.
include ROOT_PATH . 'app/views/admin/templates/header.php';
?>
<section class="table__body">
    <h1>Imágenes para: <?php echo htmlspecialchars($productData['name']); ?></h1>
    
    <h2>Imágenes Existentes</h2>
    <div class="image-gallery">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $image): ?>
                <div class="image-container">
                    <img src="/public/<?php echo htmlspecialchars($image['file_route'] . '/' . $image['file_name']); ?>" alt="Imagen de Producto">
                    <a class="delete-link" href="/admin/product_images/delete?id=<?php echo htmlspecialchars($image['id_image']); ?>&product_id=<?php echo htmlspecialchars($productData['id_product']); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta imagen?');">Eliminar</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay imágenes adicionales para este producto.</p>
        <?php endif; ?>
    </div>
    
    <h2>Subir Nueva Imagen</h2>
    <form class="form_productos" action="/admin/product_images/create?product_id=<?php echo htmlspecialchars($productData['id_product']); ?>" method="post" enctype="multipart/form-data">
        <div class="input-group">
            <label class="label_title">Seleccionar Imagen</label>
            <input type="file" id="file" name="image" accept="image/*" required>
            <div class="container">
                <div class="img-area" data-img="">
                    <i class='bx bxs-cloud-upload icon'></i>
                    <h3>Subir Imagen</h3>
                    <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                </div>
                <button type="button" class="select-image">Selecciona Imagen</button>
            </div>
            <input class="input_form btn" type="submit" value="Subir Imagen">
        </div>
    </form>
</section>
<?php include ROOT_PATH . 'app/views/admin/templates/footer.php'; ?>