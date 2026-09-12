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
     public function getById(int $id): ?array
    {
        $sql = "SELECT id, name
                FROM po_main_category
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    // UPDATE
    public function update(int $id, string $name): ?array
    {
        $sql = "UPDATE po_main_category
                SET name = :name
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':name' => $name,
            ':id' => $id
        ]);

        return $this->getById($id);
    }

    // DELETE
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM po_main_category
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->rowCount() > 0;
    }
}
