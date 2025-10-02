<?php

class Product {
    protected $db;

    public function __construct($connection) {
        $this->db = $connection;
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
        $insertImageQuery = "INSERT INTO product_images (file_name, product) 
                             VALUES (?, ?)";
        $stmtImage = $this->db->prepare($insertImageQuery);
        $stmtImage->bind_param("ssi", $fileName, $productId);
        $result = $stmtImage->execute();
        $stmtImage->close();
        
        return $result;
    }

    /**
     * Obtiene un producto por su ID, incluyendo la ruta de su imagen.
     */
    public function getById(int $id) {
        $query = "SELECT p.id_product, p.name, p.description, p.price, p.stock, p.category, p.brand, 
                         i.file_name, c.name AS name_category, b.name AS name_brand
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
            $updateImageQuery = "UPDATE product_images SET file_name = ? WHERE product = ?";
            $stmtImage = $this->db->prepare($updateImageQuery);
            $stmtImage->bind_param("ssi", $imageData['fileName'], $id);
            $imageUpdated = $stmtImage->execute();
            $stmtImage->close();
            return $imageUpdated;
        }
        
        return $productUpdated;
    }

    /**
     * Elimina el producto.
     */
    public function delete(int $idProduct) {
        // NOTA: Con la restricción FOREIGN KEY ON DELETE CASCADE, al borrar de 'products', se borra automáticamente de 'product_images'.
        $deleteQuery = "DELETE FROM products WHERE id_product = ?";
        $stmt = $this->db->prepare($deleteQuery);
        $stmt->bind_param("i", $idProduct);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Obtiene todos los productos con paginación y búsqueda.
     * @param string $searchTerm El término de búsqueda opcional.
     * @param int $start El índice de inicio para la paginación.
     * @param int $limit La cantidad de productos a obtener.
     * @return array
     */
    public function getAll(string $searchTerm = '', int $start = 0, int $limit = 20): array
    {
        // Consulta base para obtener productos, categorías, marcas e imágenes.
        $query = "SELECT 
                p.id_product,
                p.name, 
                p.price, 
                pi.file_name
              FROM products p
              LEFT JOIN product_images pi ON p.id_product = pi.product
              GROUP BY p.id_product";

        // Añadir condiciones de búsqueda si hay un término.
        if (!empty($searchTerm)) {
            $searchTerm = "%" . $this->db->real_escape_string($searchTerm) . "%";
            $query .= " WHERE p.name LIKE '{$searchTerm}' OR c.name LIKE '{$searchTerm}' OR b.name LIKE '{$searchTerm}'";
        }

        // Ordenar y limitar para la paginación.
        // $query .= " ORDER BY p.id_product ASC LIMIT {$start}, {$limit}";

        $result = $this->db->query($query);
        
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        
        return $products;
    }

    /**
     * Obtiene el conteo total de productos para la paginación.
     * @param string $searchTerm El término de búsqueda opcional.
     * @return int
     */
    public function getTotalProductsCount(string $searchTerm = ''): int
    {
        $query = "SELECT COUNT(*) as total FROM products p JOIN categories c ON p.category = c.id_category JOIN brands b ON p.brand = b.id_brand";

        if (!empty($searchTerm)) {
            $searchTerm = "%" . $this->db->real_escape_string($searchTerm) . "%";
            $query .= " WHERE p.name LIKE '{$searchTerm}' OR c.name LIKE '{$searchTerm}' OR b.name LIKE '{$searchTerm}'";
        }

        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}