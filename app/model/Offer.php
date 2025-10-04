<?php
// app/model/Offer.php

class Offer
{
    protected $db;

    public function __construct($connection)
    {
        $this->db = $connection;
    }

    /**
     * Crea una nueva oferta para un producto.
     * @param array $data Datos de la oferta (message, price).
     * @param int $productId El ID del producto al que se asocia.
     * @return bool
     */
    public function create(array $data, int $productId): bool
    {
        $insertQuery = "INSERT INTO offers (message, price, product) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($insertQuery);
        $stmt->bind_param("sdi", $data['message'], $data['price'], $productId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Obtiene una oferta específica por su ID.
     * @param int $id El ID de la oferta.
     * @return array|null
     */
    public function getById(int $id): ?array
    {
        $query = "SELECT id_offer, message, price, product FROM offers WHERE id_offer = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    /**
     * Obtiene todas las ofertas, o solo las de un producto específico.
     * @param int|null $productId El ID del producto (opcional).
     * @return array
     */
        public function getOfferedProducts(string $searchTerm = '', ?int $categoryId = null, ?int $brandId = null, bool $showOutOfStock = false): array
    {
        // Se eliminó p.model de la lista de columnas
        $query = "SELECT 
                    p.id_product, p.name, p.price, p.stock,
                    c.name as category_name,
                    b.name as brand_name,
                    pi.file_name
                FROM offers o
                INNER JOIN products p ON o.product = p.id_product
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
     * Actualiza una oferta existente.
     * @param int $id El ID de la oferta.
     * @param array $data Los nuevos datos.
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $updateQuery = "UPDATE offers SET message = ?, price = ? WHERE id_offer = ?";
        $stmt = $this->db->prepare($updateQuery);
        $stmt->bind_param("sdi", $data['message'], $data['price'], $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Elimina una oferta por su ID.
     * @param int $idOffer El ID de la oferta.
     * @return bool
     */
    public function delete(int $idOffer): bool
    {
        $deleteQuery = "DELETE FROM offers WHERE id_offer = ?";
        $stmt = $this->db->prepare($deleteQuery);
        $stmt->bind_param("i", $idOffer);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getAll(): array
    {
        $query = "SELECT 
                    p.name, 
                    p.price AS original_price, 
                    o.price AS offer_price,
                    pi.file_name,
                    o.product AS product_id
                  FROM offers o
                  JOIN products p ON o.product = p.id_product
                  LEFT JOIN product_images pi ON p.id_product = pi.product";
        
        $result = $this->db->query($query);
        $offers = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $offers[] = $row;
            }
        }
        return $offers;
    }
}