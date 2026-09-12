<?php
namespace src\Repositories;
use src\config\Database;
use PDO;


class UOMRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    public function create($data){
        try{
            print_r($data);
            $query="INSERT INTO uom
            (unit_of_measurement )
            VALUES
            (
                :unit_of_measurement 
            )";
            $stmt=$this->db->prepare($query);
            $stmt->execute([
                ':unit_of_measurement'=>$data['unit_of_measurement']
            ]);
            return true;
        }
        catch(\Throwable $e){
             die($e->getMessage());

        }
    }

    public function getUom(){
        try{
            $query="SELECT * FROM uom";
            $stmt=$this->db->prepare($query);
            $stmt->execute();
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(\Throwable $e){
            die($e->getMessage());
        }
    }
    // GET BY ID
    public function getById(int $id): ?array
    {
        $sql = "SELECT
                    id,
                    unit_of_measurement
                FROM uom
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    // UPDATE
    public function update(int $id, array $data): ?array
    {
        $sql = "UPDATE uom
                SET unit_of_measurement = :unit_of_measurement
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':unit_of_measurement' => $data['unit_of_measurement'],
            ':id' => $id
        ]);

        return $this->getById($id);
    }

    // DELETE
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM uom
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->rowCount() > 0;
    }
}
