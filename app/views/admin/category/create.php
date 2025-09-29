<?php 
// La variable $alert debe ser proporcionada por el controlador.
include ROOT_PATH . 'app/views/admin/templates/header.php';
?>
<form class="form_productos" action="/admin/categories/create" method="post">
    <div class="input-group">
        <label class="label_title">Nombre</label>
        <input type="text" class="input_form" name="name" placeholder="Nombre de la categoría">
        <input class="input_form btn" type="submit" value="Agregar Categoría">
    </div>
</form>
<?php include ROOT_PATH . 'app/views/admin/templates/footer.php'; ?>