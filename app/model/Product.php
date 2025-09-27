<?php

// NOTA: Asegúrate de que bd_conexion.php provea la conexión $conexion (mysqli)
// Se asume que $conexion está disponible globalmente, o se pasa al constructor.

class Product {
    protected $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    /**
     * Crea un nuevo producto y su entrada de imagen.
     * @param array $datos Datos del producto.
     * @param string $fileName Nombre del archivo (ej: 'unique-id.jpg').
     * @param string $fileRoute Ruta de la carpeta (ej: 'public/uploads/products').
     * @return bool
     */
    public function create(array $datos, string $fileName, string $fileRoute) {
        // 1. Crear el producto en la tabla 'products'
        $insertProductQuery = "INSERT INTO products (name, category, brand, description, price, stock) 
                               VALUES (?, ?, ?, ?, ?, ?)";
        $stmtProduct = $this->db->prepare($insertProductQuery);
        // Tipos de datos: s=string, i=integer, d=double (asumiendo precios y stocks pueden ser strings en tu DB)
        $stmtProduct->bind_param("siisds", 
            $datos['name'], $datos['category'], $datos['brand'], $datos['description'], 
            $datos['price'], $datos['stock']
        );
        
        if (!$stmtProduct->execute()) {
            return false;
        }
        
        $productId = $stmtProduct->insert_id;
        $stmtProduct->close();
        
        // 2. Crear la entrada en la tabla 'product_images'
        $insertImageQuery = "INSERT INTO product_images (file_name, file_route, product) 
                             VALUES (?, ?, ?)";
        $stmtImage = $this->db->prepare($insertImageQuery);
        $stmtImage->bind_param("ssi", $fileName, $fileRoute, $productId);
        $result = $stmtImage->execute();
        $stmtImage->close();
        
        return $result;
    }

    /**
     * Obtiene un producto por su ID, incluyendo la ruta de su imagen.
     */
    public function getById(int $id) {
        $query = "SELECT p.id_product, p.name, p.description, p.price, p.stock, p.category, p.brand, 
                         i.file_name, i.file_route, c.name AS name_category, b.name AS name_brand
                  FROM products p
                  JOIN categories c ON p.category = c.id_category
                  JOIN brands b ON p.brand = b.id_brand
                  LEFT JOIN product_images i ON p.id_product = i.product
                  WHERE p.id_product = ?";
                  
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    /**
     * Actualiza el producto (opcionalmente con nueva imagen).
     */
    public function update(int $id, array $datos, ?array $imageData = null) {
        // 1. Actualizar la tabla 'products' (similar a tu lógica original sin img_product)
        $updateProductQuery = "UPDATE products SET name = ?, category = ?, brand = ?, description = ?, price = ?, stock = ? WHERE id_product = ?";
        $stmtProduct = $this->db->prepare($updateProductQuery);
        $stmtProduct->bind_param("siidsii", 
            $datos['name'], $datos['category'], $datos['brand'], $datos['description'], 
            $datos['price'], $datos['stock'], $id
        );
        $productUpdated = $stmtProduct->execute();
        $stmtProduct->close();
        
        // 2. Actualizar la tabla 'product_images' si se proveen datos
        if ($imageData && $productUpdated) {
            $updateImageQuery = "UPDATE product_images SET file_name = ?, file_route = ? WHERE product = ?";
            $stmtImage = $this->db->prepare($updateImageQuery);
            $stmtImage->bind_param("ssi", $imageData['fileName'], $imageData['fileRoute'], $id);
            $imageUpdated = $stmtImage->execute();
            $stmtImage->close();
            return $imageUpdated; // Retorna el éxito de la actualización de la imagen (o el producto si la imagen no se actualizó)
        }
        
        return $productUpdated;
    }

    /**
     * Elimina el producto.
     */
    public function delete(int $idProduct) {
        // NOTA: Con la restricción FOREIGN KEY ON DELETE CASCADE, al borrar de 'products', se borra automáticamente de 'product_images'.
        // Si no tienes CASCADE, necesitarás dos DELETE. Asumiremos que tienes CASCADE como en el esquema nuevo.
        $deleteQuery = "DELETE FROM products WHERE id_product = ?";
        $stmt = $this->db->prepare($deleteQuery);
        $stmt->bind_param("i", $idProduct);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
    // ... otros métodos (obtenerTodos, contarTotal, etc. para lista_productos.php)
    
    // NOTA: Debes crear métodos en otros Modelos (ej: Category.php, Brand.php)
    // para las consultas de los SELECT en las vistas (como obtenerCategorias() y obtenerMarcas()).
}