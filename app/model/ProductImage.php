<?php
// app/model/ProductImage.php

class ProductImage
{
    protected $db;

    public function __construct($connection)
    {
        $this->db = $connection;
    }

    /**
     * Agrega una nueva imagen para un producto.
     * @param string $fileName Nombre del archivo de imagen.
     * @param string $fileRoute Ruta de la carpeta.
     * @param int $productId El ID del producto.
     * @return bool
     */
    public function create(string $fileName, string $fileRoute, int $productId): bool
    {
        $insertQuery = "INSERT INTO product_images (file_name, file_route, product) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($insertQuery);
        $stmt->bind_param("ssi", $fileName, $fileRoute, $productId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Obtiene una imagen por su ID.
     * @param int $id El ID de la imagen.
     * @return array|null
     */
    public function getById(int $id): ?array
    {
        $query = "SELECT id_image, file_name, file_route, product FROM product_images WHERE id_image = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    /**
     * Obtiene todas las imágenes de un producto específico.
     * @param int $productId El ID del producto.
     * @return array
     */
    public function getAllForProduct(int $productId): array
    {
        $query = "SELECT id_image, file_name, file_route FROM product_images WHERE product = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row;
        }
        $stmt->close();
        return $images;
    }

    /**
     * Actualiza el registro de una imagen.
     * @param int $id El ID de la imagen.
     * @param string $fileName El nuevo nombre de archivo.
     * @param string $fileRoute La nueva ruta.
     * @return bool
     */
    public function update(int $id, string $fileName, string $fileRoute): bool
    {
        $updateQuery = "UPDATE product_images SET file_name = ?, file_route = ? WHERE id_image = ?";
        $stmt = $this->db->prepare($updateQuery);
        $stmt->bind_param("ssi", $fileName, $fileRoute, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Elimina una imagen por su ID.
     * @param int $idImage El ID de la imagen a eliminar.
     * @return bool
     */
    public function delete(int $idImage): bool
    {
        $deleteQuery = "DELETE FROM product_images WHERE id_image = ?";
        $stmt = $this->db->prepare($deleteQuery);
        $stmt->bind_param("i", $idImage);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}