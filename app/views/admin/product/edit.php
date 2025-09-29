<?php
// app/views/admin/product/edit.php
// El controlador ya obtuvo el producto, categorías y marcas.
// Esta vista solo muestra el formulario pre-rellenado.
?>
        <form class="form_productos" action="/admin/products/update?id=<?php echo htmlspecialchars($productData['id_product']); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_product" value="<?php echo htmlspecialchars($productData['id_product']); ?>">
            <div class="input-group">
                <label class="label_title">Nombre</label>
                <input type="text" class="input_form" name="name" placeholder="Nombre" value="<?php echo htmlspecialchars($productData['name']); ?>" autocomplete="name" required>

                <label class="label_title">Categoría</label>
                <select class="input_form" name="category" required>
                    <option disabled>Seleccionar Categoría</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['id_category']; ?>" 
                            <?php echo ($category['id_category'] == $productData['category']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label class="label_title">Marca</label>
                <select class="input_form" name="brand" required>
                    <option disabled>Seleccionar Marca</option>
                    <?php foreach ($brands as $brand) : ?>
                        <option value="<?php echo $brand['id_brand']; ?>" 
                            <?php echo ($brand['id_brand'] == $productData['brand']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($brand['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label class="label_title">Precio</label>
                <input type="text" class="input_form" name="price" placeholder="Precio" value="<?php echo htmlspecialchars($productData['price']); ?>" required>

                <label class="label_title">Stock</label>
                <input type="text" class="input_form" name="stock" placeholder="Stock" value="<?php echo htmlspecialchars($productData['stock']); ?>" required>

                <label class="label_title">Descripción</label>
                <textarea name="description" class="input_form" cols="30" rows="8" placeholder="Descripción" required><?php echo htmlspecialchars($productData['description']); ?></textarea>

                <label class="label_title">Imagen del Producto</label>
                <input type="file" id="file" name="image" accept="image/*" hidden>

                <div class="container">
                    <div class="img-area">
                        <img id="preview-image" src="/public/<?php echo htmlspecialchars($productData['file_route'] . '/' . $productData['file_name']); ?>" alt="Imagen del producto actual">
                    </div>
                    <button type="button" class="select-image">Selecciona Imagen</button>
                </div>

                <input class="input_form btn" type="submit" value="Actualizar">
            </div>
        </form>