<?php
namespace src\Repositories;
use src\config\Database;
use PDO;

class ReturnReasonRepository{
    private \PDO $db;
    
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function create(array $data){
        // print_r($data);
        $sql="INSERT INTO purchase_return_reason (reason) VALUES (:reason)";
        try{
            $stmt=$this->db->prepare($sql);
            $stmt->execute([
                    ':reason'=>$data['reason']
            ]);
            $id=(int)$this->db->lastInsertId();
            return[
                'id'=>$id,
                'reason'=>$data['reason']
            ];
        }
        catch(\Throwable $e){
            die($e);
        }
    }

    public function getAll(){
        $sql="SELECT * FROM purchase_return_reason";
        try{
            $stmt=$this->db->query($sql);
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            // print_r($result);
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
                    reason
                FROM purchase_return_reason
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
        $sql = "UPDATE purchase_return_reason
                SET reason = :reason
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':reason' => $data['reason'],
            ':id' => $id
        ]);

        return $this->getById($id);
    }

    // DELETE
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM purchase_return_reason
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->rowCount() > 0;
    }
}

?>