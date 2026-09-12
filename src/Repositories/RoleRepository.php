<?php
namespace src\Repositories;
use src\config\Database;
use PDO;

class RoleRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function create(array $data)
    {
        $query = "INSERT INTO role (role_name) VALUES (:role_name)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':role_name', $data['role_name']);
        $stmt->execute();
        return ['id' => $this->db->lastInsertId(), 'role_name' => $data['role_name']];
    }

    public function getAll()
    {
        $query = "SELECT * FROM role";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function update(array $data)
    // {
    //     $query = "UPDATE roles SET name = :name, description = :description WHERE id = :id";
    //     $stmt = $this->db->prepare($query);
    //     $stmt->bindParam(':id', $data['id']);
    //     $stmt->bindParam(':name', $data['name']);
    //     $stmt->bindParam(':description', $data['description']);
    //     return $stmt->execute();
    // }
}


?>