<?php
namespace src\Repositories;
use src\config\Database;
use PDO;

class LocationRepository{
    private PDO $db;
    public function __construct()
    {
        $this->db=Database::getConnection();
    }

    public function createLocation(array $data){
        try{
            $query=("INSERT INTO location (name) VALUES (:name)");
            $stmt=$this->db->prepare($query);
            $stmt->bindParam(':name',$data['name']);
            $stmt->execute();
            return ['id' => $this->db->lastInsertId(), 'name' => $data['name']];
        }
        catch(\Throwable $e){
            die($e->getMessage());
        }
    }

    public function getLocation(){
        $query="SELECT * FROM location";
        try{
            $stmt=$this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
        catch(\Throwable $e){
            die($e->getMessage());
        }
    }
     public function getById(int $id): ?array
    {
        $sql = "SELECT id, name
                FROM location
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
        $sql = "UPDATE location
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
        $sql = "DELETE FROM location
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->rowCount() > 0;
    }



}
?>