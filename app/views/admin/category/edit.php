<?php 
// La variable $categoryData debe ser proporcionada por el controlador.
include ROOT_PATH . 'app/views/admin/templates/header.php';
?>
<form class="form_productos" action="/admin/categories/update" method="post">
    <div class="input-group">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($categoryData['id_category']); ?>">
        <label class="label_title">Nombre</label>
        <input type="text" class="input_form" name="name" placeholder="Nombre de la categoría" value="<?php echo htmlspecialchars($categoryData['name']); ?>">
        <input class="input_form btn" type="submit" value="Actualizar Categoría">
    </div>
</form>
<?php include ROOT_PATH . 'app/views/admin/templates/footer.php'; ?>