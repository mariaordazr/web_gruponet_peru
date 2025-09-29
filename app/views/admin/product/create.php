<?php
// app/views/admin/product/create.php
// La lógica de obtención de categorías y marcas se hizo en el controlador.
// Esta vista solo muestra el formulario.
?>
        <form class="form_productos" action="/admin/products/create" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <label class="label_title">Nombre</label>
                <input type="text" class="input_form" name="name" placeholder="Nombre" required>

                <label class="label_title">Categoría</label>
                <select class="input_form" name="category" required>
                    <option selected disabled>Seleccionar Categoría</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['id_category']; ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label class="label_title">Marca</label>
                <select class="input_form" name="brand" required>
                    <option selected disabled>Seleccionar Marca</option>
                    <?php foreach ($brands as $brand) : ?>
                        <option value="<?php echo $brand['id_brand']; ?>">
                            <?php echo htmlspecialchars($brand['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label class="label_title">Precio</label>
                <input type="text" class="input_form" name="price" placeholder="Precio" required>

                <label class="label_title">Stock</label>
                <input type="text" class="input_form" name="stock" placeholder="Stock" required>

                <label class="label_title">Descripción</label>
                <textarea name="description" class="input_form" cols="30" rows="5" placeholder="Descripción" required></textarea>

                <label class="label_title">Imagen del Producto</label>
                <div class="container">
                    <input type="file" id="file" name="image" accept="image/*" hidden required>
                    <div class="img-area" data-img="">
                        <i class='bx bxs-cloud-upload icon'></i>
                        <h3>Upload Image</h3>
                        <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                    </div>
                    <button type="button" class="select-image">Selecciona Imagen</button>
                </div>

                <input class="input_form btn" type="submit" value="Crear">
            </div>
        </form>