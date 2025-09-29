<?php 
// La variable $brandData debe ser proporcionada por el controlador.
include ROOT_PATH . 'app/views/admin/templates/header.php';
?>
<form class="form_productos" action="/admin/brands/update" method="post">
    <div class="input-group">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($brandData['id_brand']); ?>">
        <label class="label_title">Nombre</label>
        <input type="text" class="input_form" name="name" placeholder="Nombre de la marca" value="<?php echo htmlspecialchars($brandData['name']); ?>">
        <input class="input_form btn" type="submit" value="Actualizar Marca">
    </div>
</form>
<?php include ROOT_PATH . 'app/views/admin/templates/footer.php'; ?>