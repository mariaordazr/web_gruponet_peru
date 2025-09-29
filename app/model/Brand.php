<?php
// app/model/Brand.php

class Brand
{
    protected $db;

    public function __construct($connection)
    {
        $this->db = $connection;
    }

    /**
     * Crea una nueva marca en la base de datos.
     * Corresponde a la lógica de agregar_marca.php
     * @param string $name El nombre de la marca.
     * @return bool
     */
    public function create(string $name): bool
    {
        $insertQuery = "INSERT INTO brands (name) VALUES (?)";
        $stmt = $this->db->prepare($insertQuery);
        $stmt->bind_param("s", $name);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Obtiene todas las marcas de la base de datos.
     * Corresponde a la lógica de lista_marcas.php
     * @return array
     */
    public function getAll(): array
    {
        $query = "SELECT id_brand, name FROM brands ORDER BY name ASC";
        $result = $this->db->query($query);
        $brands = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $brands[] = $row;
            }
        }
        return $brands;
    }

    /**
     * Obtiene una marca por su ID.
     * Corresponde a la lógica de editar_marca.php
     * @param int $id El ID de la marca.
     * @return array|null
     */
    public function getById(int $id): ?array
    {
        $query = "SELECT id_brand, name FROM brands WHERE id_brand = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    /**
     * Actualiza el nombre de una marca.
     * Corresponde a la lógica de editar_marca.php
     * @param int $id El ID de la marca.
     * @param string $name El nuevo nombre.
     * @return bool
     */
    public function update(int $id, string $name): bool
    {
        $updateQuery = "UPDATE brands SET name = ? WHERE id_brand = ?";
        $stmt = $this->db->prepare($updateQuery);
        $stmt->bind_param("si", $name, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Elimina una marca de la base de datos.
     * Corresponde a la lógica de eliminar_marca.php
     * @param int $id El ID de la marca a eliminar.
     * @return bool
     */
    public function delete(int $id): bool
    {
        $deleteQuery = "DELETE FROM brands WHERE id_brand = ?";
        $stmt = $this->db->prepare($deleteQuery);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}