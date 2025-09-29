<?php
// app/model/User.php (Actualizado)

class User
{
    protected $db;

    public function __construct($connection)
    {
        $this->db = $connection;
    }

    /**
     * Busca un usuario por sus credenciales para el inicio de sesión.
     * @param string $username El nombre de usuario.
     * @param string $password La contraseña sin encriptar.
     * @return array|null Los datos del usuario si las credenciales son correctas.
     */
    public function getUserByCredentials(string $username, string $password): ?array
    {
        // En tu DB actual, la contraseña está encriptada con MD5
        $hashedPassword = md5($password);
        
        $query = "SELECT id_user, username, name, email FROM users WHERE username = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $username, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }

    /**
     * Crea un nuevo usuario administrador.
     * @param array $data Los datos del nuevo usuario.
     * @return bool
     */
    public function create(array $data): bool
    {
        // RECOMENDACIÓN: Usar password_hash() para una encriptación más segura.
        // Adaptamos el código a tu DB actual que usa MD5.
        $hashedPassword = md5($data['password']);
        
        $insertQuery = "INSERT INTO users (username, name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($insertQuery);
        $stmt->bind_param("ssss", $data['username'], $data['name'], $data['email'], $hashedPassword);
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

    /**
     * Obtiene una lista de todos los usuarios.
     * @return array
     */
    public function getAll(): array
    {
        $query = "SELECT id_user, username, name, email FROM users";
        $result = $this->db->query($query);
        
        $users = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    /**
     * Obtiene los datos de un usuario por su ID.
     * @param int $id El ID del usuario.
     * @return array|null
     */
    public function getById(int $id): ?array
    {
        $query = "SELECT id_user, username, name, email FROM users WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    /**
     * Actualiza un usuario existente.
     * @param int $id El ID del usuario.
     * @param array $data Los nuevos datos.
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $updateQuery = "UPDATE users SET username = ?, name = ?, email = ? WHERE id_user = ?";
        $stmt = $this->db->prepare($updateQuery);
        $stmt->bind_param("sssi", $data['username'], $data['name'], $data['email'], $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
    /**
     * Elimina un usuario por su ID.
     * @param int $id El ID del usuario.
     * @return bool
     */
    public function delete(int $id): bool
    {
        $deleteQuery = "DELETE FROM users WHERE id_user = ?";
        $stmt = $this->db->prepare($deleteQuery);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}