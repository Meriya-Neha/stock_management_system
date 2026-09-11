<?php
namespace src\Repositories;
use src\config\Database;
use Throwable;  
use PDO;
use PDOException;

class PoMainCategoryRepository
{
    private \PDO $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    public function create(array $data)
    {
        $query = "INSERT INTO po_main_category (id,	name, created_at) VALUES (:id, :name, :created_at)";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':name' => $data['name'],
                ':created_at' => $data['created_at'],
            ]);
            return true;
        } catch (Throwable $e) {
            die($e->getMessage());
            return false;
        }
    }
}
