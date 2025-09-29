<?php
// app/views/admin/user/create.php
include ROOT_PATH . 'app/views/admin/templates/header.php';
?>
<form class="form_productos" action="/admin/users/create" method="post">
    <div class="input-group">
        <label class="label_title">Nombre Completo</label>
        <input type="text" class="input_form" name="name" placeholder="Nombre" required>

        <label class="label_title">Usuario</label>
        <input type="text" class="input_form" name="username" placeholder="Nombre de usuario" required>

        <label class="label_title">Email</label>
        <input type="email" class="input_form" name="email" placeholder="Email" required>

        <label class="label_title">Contraseña</label>
        <input type="password" class="input_form" name="password" placeholder="Contraseña" required>

        <input class="input_form btn" type="submit" value="Crear Usuario">
    </div>
</form>
<?php include ROOT_PATH . 'app/views/admin/templates/footer.php'; ?>