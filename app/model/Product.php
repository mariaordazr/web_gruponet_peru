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
    
    public function getAll(string $searchTerm = '', ?int $categoryId = null, ?int $brandId = null, bool $showOutOfStock = false): array
    {
        // Se eliminó p.model de la lista de columnas
        $query = "SELECT 
                    p.id_product, p.name, p.price, p.stock,
                    c.name as category_name,
                    b.name as brand_name,
                    pi.file_name
                FROM products p
                LEFT JOIN categories c ON p.category = c.id_category
                LEFT JOIN brands b ON p.brand = b.id_brand
                LEFT JOIN product_images pi ON p.id_product = pi.product";

        $conditions = [];
        $params = [];
        $types = '';

        // Búsqueda por término (modificado para buscar solo en el nombre)
        if (!empty($searchTerm)) {
            $conditions[] = "p.name LIKE ?"; // Se eliminó la condición OR p.model LIKE ?
            $likeTerm = "%{$searchTerm}%";
            $params[] = $likeTerm;
            $types .= 's';
        }

        // Filtro por categoría
        if ($categoryId !== null) {
            $conditions[] = "p.category = ?";
            $params[] = $categoryId;
            $types .= 'i';
        }

        // Filtro por marca
        if ($brandId !== null) {
            $conditions[] = "p.brand = ?";
            $params[] = $brandId;
            $types .= 'i';
        }
        
        // Filtro por stock agotado
        if ($showOutOfStock) {
            $conditions[] = "p.stock = 0";
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $query .= " GROUP BY p.id_product ORDER BY p.id_product DESC";

        $stmt = $this->db->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        $stmt->close();
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

    public function countTotalProducts(): int
    {
        $result = $this->db->query("SELECT COUNT(id_product) as total FROM products");
        $row = $result->fetch_assoc();
        return (int) $row['total'];
    }

    public function countNewArrivals(): int
    {
        // Si tu tabla 'new_products' no tiene 'created_at', esta consulta fallará.
        // Una alternativa sería contar todos los registros de 'new_products'.
        $result = $this->db->query("SELECT COUNT(id_new_product) as total FROM new_products");
        if (!$result) return 0; // Manejo de error si la columna no existe
        $row = $result->fetch_assoc();
        return (int) $row['total'];
    }


    public function countOutOfStock(): int
    {
        $result = $this->db->query("SELECT COUNT(id_product) as total FROM products WHERE stock = 0");
        $row = $result->fetch_assoc();
        return (int) $row['total'];
    }

    public function countLowStock(): int
    {
        $result = $this->db->query("SELECT COUNT(id_product) as total FROM products WHERE stock > 0 AND stock < 10");
        $row = $result->fetch_assoc();
        return (int) $row['total'];
    }

}