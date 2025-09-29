<?php
// app/model/NewProduct.php

class NewProduct
{
    protected $db;

    public function __construct($connection)
    {
        $this->db = $connection;
    }

    /**
     * Crea una nueva entrada en la tabla 'new_products' para marcar un producto como nuevo.
     * @param int $productId El ID del producto existente.
     * @return bool
     */
    public function create(int $productId): bool
    {
        // Se utiliza la transacción para asegurar que la operación sea atómica.
        $this->db->begin_transaction();
        try {
            // Se verifica si el producto ya está marcado como nuevo para evitar duplicados.
            $checkQuery = "SELECT id_new_product FROM new_products WHERE product = ?";
            $checkStmt = $this->db->prepare($checkQuery);
            $checkStmt->bind_param("i", $productId);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                $this->db->rollback();
                return false; // El producto ya existe como 'nuevo'.
            }
            $checkStmt->close();

            // Si no existe, se inserta el nuevo registro.
            $insertQuery = "INSERT INTO new_products (product) VALUES (?)";
            $stmt = $this->db->prepare($insertQuery);
            $stmt->bind_param("i", $productId);
            if (!$stmt->execute()) {
                throw new Exception("Error al marcar el producto como nuevo.");
            }
            $stmt->close();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    /**
     * Obtiene una entrada de producto nuevo por su ID de registro en la tabla 'new_products'.
     * @param int $id El ID del registro en 'new_products'.
     * @return array|null
     */
    public function getById(int $id): ?array
    {
        $query = "SELECT * FROM new_products WHERE id_new_product = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    /**
     * Obtiene todos los productos marcados como "nuevos", incluyendo su información del producto principal.
     * @return array
     */
    public function getAll(): array
    {
        $query = "SELECT 
                    p.name, 
                    p.price, 
                    pi.file_name, 
                    pi.file_route, 
                    np.id_new_product
                  FROM new_products np
                  JOIN products p ON np.product = p.id_product
                  LEFT JOIN product_images pi ON p.id_product = pi.product";
        
        $result = $this->db->query($query);
        $newProducts = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $newProducts[] = $row;
            }
        }
        return $newProducts;
    }

    /**
     * Elimina el registro de un producto de la tabla 'new_products'.
     * @param int $id El ID del registro en 'new_products'.
     * @return bool
     */
    public function delete(int $id): bool
    {
        $deleteQuery = "DELETE FROM new_products WHERE id_new_product = ?";
        $stmt = $this->db->prepare($deleteQuery);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}