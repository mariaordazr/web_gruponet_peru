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
    public function getAll(?int $productId = null): array
    {
        $query = "SELECT 
                    p.price, 
                    o.message, 
                    pi.file_name
                  FROM offers o
                  JOIN products p ON o.product = p.id_product
                  LEFT JOIN product_images pi ON p.id_product = pi.product";
        
        if ($productId !== null) {
            $query .= " WHERE o.product = ?";
        }
        $query .= " ORDER BY o.id_offer ASC";

        $stmt = $this->db->prepare($query);
        if ($productId !== null) {
            $stmt->bind_param("i", $productId);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        $offers = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $offers[] = $row;
            }
        }
        $stmt->close();
        return $offers;
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
}