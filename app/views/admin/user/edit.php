<?php
// app/views/admin/user/edit.php
// La variable $userData es proporcionada por el controlador.
include ROOT_PATH . 'app/views/admin/templates/header.php';
?>
<form class="form_productos" action="/admin/users/update?id=<?php echo htmlspecialchars($userData['id_user']); ?>" method="post">
    <div class="input-group">
        <label class="label_title">Nombre Completo</label>
        <input type="text" class="input_form" name="name" placeholder="Nombre" value="<?php echo htmlspecialchars($userData['name']); ?>" required>

        <label class="label_title">Usuario</label>
        <input type="text" class="input_form" name="username" placeholder="Nombre de usuario" value="<?php echo htmlspecialchars($userData['username']); ?>" required>

        <label class="label_title">Email</label>
        <input type="email" class="input_form" name="email" placeholder="Email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>

        <input class="input_form btn" type="submit" value="Actualizar Usuario">
    </div>
</form>
<?php include ROOT_PATH . 'app/views/admin/templates/footer.php'; ?>