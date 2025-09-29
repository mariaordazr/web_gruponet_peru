<?php
// app/views/admin/user/list.php
// La variable $users es proporcionada por el controlador.
include ROOT_PATH . 'app/views/admin/templates/header.php';
?>
<section class="table__body">
    <a href="/admin/users/create" class="btn-table_edit">Agregar Usuario</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id_user']); ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <a class="btn-table_edit" href="/admin/users/update?id=<?php echo htmlspecialchars($user['id_user']); ?>"><i class='bx bx-edit-alt'></i></a>
                            <a class="btn-table_delete" href="/admin/users/delete?id=<?php echo htmlspecialchars($user['id_user']); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');"><i class='bx bx-trash'></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
<?php include ROOT_PATH . 'app/views/admin/templates/footer.php'; ?>