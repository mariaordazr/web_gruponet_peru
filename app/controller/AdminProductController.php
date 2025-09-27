<?php
// Incluir la conexión a la base de datos (bd_conexion.php)
// NOTA: Se asume que $connection está disponible globalmente o se pasa al constructor.

class Product 
{
    protected $db; // Conexión a la base de datos (mysqli o PDO)

    public function __construct($connection) 
    {
        $this->db = $connection;
    }

    /**
     * Crea un nuevo producto en la tabla 'products' y su entrada de imagen en 'product_images'.
     * @param array $data Los datos del formulario del producto.
     * @param string $fileName El nombre único del archivo de imagen.
     * @param string $fileRoute La ruta de la carpeta donde se guarda la imagen (ej: 'uploads/products/').
     * @return bool
     */
    public function create(array $data, string $fileName, string $fileRoute): bool
    {
        // 1. Inserción en la tabla 'products'
        $insertProductQuery = "INSERT INTO products (name, category, brand, description, price, stock) 
                               VALUES (?, ?, ?, ?, ?, ?)";
        $stmtProduct = $this->db->prepare($insertProductQuery);
        // Usamos los nombres de columna de la nueva DB: name, category, brand, description, price, stock
        $stmtProduct->bind_param("siisds", 
            $data['name'], $data['category'], $data['brand'], $data['description'], 
            $data['price'], $data['stock']
        );
        
        if (!$stmtProduct->execute()) {
            return false;
        }
        
        $productId = $stmtProduct->insert_id;
        $stmtProduct->close();
        
        // 2. Inserción en la tabla 'product_images' (usando el ID del producto creado)
        $insertImageQuery = "INSERT INTO product_images (file_name, file_route, product) 
                             VALUES (?, ?, ?)";
        $stmtImage = $this->db->prepare($insertImageQuery);
        $stmtImage->bind_param("ssi", $fileName, $fileRoute, $productId);
        $result = $stmtImage->execute();
        $stmtImage->close();
        
        return $result;
    }

    /**
     * Obtiene un producto por su ID, uniendo las tablas de Categoría, Marca e Imagen.
     * @param int $idProduct El ID del producto.
     * @return array|null
     */
    public function getById(int $idProduct): ?array
    {
        $query = "SELECT p.*, c.name AS category_name, b.name AS brand_name, 
                         i.file_name, i.file_route
                  FROM products p
                  JOIN categories c ON p.category = c.id_category
                  JOIN brands b ON p.brand = b.id_brand
                  LEFT JOIN product_images i ON p.id_product = i.product
                  WHERE p.id_product = ?";
                  
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $idProduct);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }
    
    /**
     * Actualiza los datos de un producto. Opcionalmente, actualiza la información de la imagen.
     * @param int $idProduct El ID del producto.
     * @param array $data Los nuevos datos.
     * @param array|null $imageData Datos de la nueva imagen si se sube.
     * @return bool
     */
    public function update(int $idProduct, array $data, ?array $imageData = null): bool
    {
        // 1. Actualizar la tabla 'products'
        $updateProductQuery = "UPDATE products SET name = ?, category = ?, brand = ?, description = ?, price = ?, stock = ? WHERE id_product = ?";
        $stmtProduct = $this->db->prepare($updateProductQuery);
        $stmtProduct->bind_param("siidsii", 
            $data['name'], $data['category'], $data['brand'], $data['description'], 
            $data['price'], $data['stock'], $idProduct
        );
        $productUpdated = $stmtProduct->execute();
        $stmtProduct->close();
        
        // 2. Actualizar la tabla 'product_images' si se proveen datos de imagen
        if ($imageData && $productUpdated) {
            $updateImageQuery = "UPDATE product_images SET file_name = ?, file_route = ? WHERE product = ?";
            $stmtImage = $this->db->prepare($updateImageQuery);
            $stmtImage->bind_param("ssi", $imageData['fileName'], $imageData['fileRoute'], $idProduct);
            $imageUpdated = $stmtImage->execute();
            $stmtImage->close();
            return $imageUpdated;
        }
        
        return $productUpdated;
    }

    /**
     * Elimina el producto por su ID (la imagen asociada se borra por CASCADE en la BD).
     * @param int $idProduct El ID del producto a eliminar.
     * @return bool
     */
    public function delete(int $idProduct): bool
    {
        $deleteQuery = "DELETE FROM products WHERE id_product = ?";
        $stmt = $this->db->prepare($deleteQuery);
        $stmt->bind_param("i", $idProduct);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Actualiza el estado de un producto (Activo/Agotado).
     * @param int $idProduct El ID del producto.
     * @param string $status El nuevo estado ('Activo' o 'Agotado').
     * @return bool
     */
    public function updateStatus(int $idProduct, string $status): bool
    {
        $query = "UPDATE products SET status = ? WHERE id_product = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $status, $idProduct);
        return $stmt->execute();
    }
    
    // NOTA: Aquí irían los métodos obtenerTodos(), contarTotal(), etc. para la paginación.
}