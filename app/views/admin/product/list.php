<?php
// app/views/admin/product/list.php
// La lógica de paginación y obtención de productos ya se hizo en AdminProductController::index().
// Ahora esta vista solo muestra los datos.
?>
        <form method="GET" action="/admin/products" class="header__search">
            <input type="search" name="search" class="header__input" placeholder="Buscar productos" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit"><i class='bx bx-search header__icon'></i></button>
        </form>

        <div class="pagination">
            <?php if ($currentPage > 1) : ?>
                <a href="/admin/products?page=<?php echo $currentPage - 1; ?>&search=<?php echo urlencode($searchTerm); ?>">&laquo;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <a href="/admin/products?page=<?php echo $i; ?>&search=<?php echo urlencode($searchTerm); ?>" <?php if ($i == $currentPage) echo 'class="active"'; ?>><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages) : ?>
                <a href="/admin/products?page=<?php echo $currentPage + 1; ?>&search=<?php echo urlencode($searchTerm); ?>">&raquo;</a>
            <?php endif; ?>
        </div>

        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($products) > 0) : ?>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td><?php echo $product['id_product']; ?></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                <td><?php echo htmlspecialchars($product['brand_name']); ?></td>
                                <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                <td>S/.<?php echo htmlspecialchars($product['price']); ?></td>
                                <td>
                                    <img src="/public/<?php echo htmlspecialchars($product['file_route'] . '/' . $product['file_name']); ?>" alt="img-producto">
                                </td>
                                <td>
                                    <a class="btn-table_edit" href="/admin/products/update?id=<?php echo $product['id_product']; ?>"><i class='bx bx-edit-alt'></i></a>
                                    <a class="btn-table_delete" href="/admin/products/delete?id=<?php echo $product['id_product']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');"><i class='bx bx-trash'></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8">No se encontraron productos.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>