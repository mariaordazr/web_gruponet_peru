<?php
// app/model/Category.php

class Category
{
    protected $db;

    public function __construct($connection)
    {
        $this->db = $connection;
    }

    /**
     * Crea una nueva categoría en la base de datos.
     * Corresponde a la lógica de agregar_categoria.php
     * @param string $name El nombre de la categoría.
     * @return bool
     */
    public function create(string $name): bool
    {
        $insertQuery = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $this->db->prepare($insertQuery);
        $stmt->bind_param("s", $name);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Obtiene todas las categorías de la base de datos.
     * Corresponde a la lógica de lista_categoria.php
     * @return array
     */
    public function getAll(): array
    {
        $query = "SELECT id_category, name FROM categories ORDER BY name ASC";
        $result = $this->db->query($query);
        $categories = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        return $categories;
    }

    /**
     * Obtiene una categoría por su ID.
     * Corresponde a la lógica de editar_categoria.php
     * @param int $id El ID de la categoría.
     * @return array|null
     */
    public function getById(int $id): ?array
    {
        $query = "SELECT id_category, name FROM categories WHERE id_category = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    /**
     * Actualiza el nombre de una categoría.
     * Corresponde a la lógica de editar_categoria.php
     * @param int $id El ID de la categoría.
     * @param string $name El nuevo nombre.
     * @return bool
     */
    public function update(int $id, string $name): bool
    {
        $updateQuery = "UPDATE categories SET name = ? WHERE id_category = ?";
        $stmt = $this->db->prepare($updateQuery);
        $stmt->bind_param("si", $name, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Elimina una categoría de la base de datos.
     * No se adjuntó archivo, pero es una función estándar.
     * @param int $id El ID de la categoría a eliminar.
     * @return bool
     */
    public function delete(int $id): bool
    {
        $deleteQuery = "DELETE FROM categories WHERE id_category = ?";
        $stmt = $this->db->prepare($deleteQuery);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}