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
        $query = "INSERT INTO po_main_category (	name) VALUES (:name)";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':name' => $data['name']
            ]);
            return true;
        } catch (Throwable $e) {
            die($e->getMessage());
            return false;
        }
    }
    public function getAll()
    {
        $query = "SELECT * FROM po_main_category";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            die($e->getMessage());
            return [];
        }
    }
    public function update(array $data)
    {
        $query = "UPDATE po_main_category SET name = :name WHERE id = :id";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':name' => $data['name'],
                ':id' => $data['id']
            ]);
            return true;
        } catch (Throwable $e) {
            die($e->getMessage());
            return false;
        }
    }
}
