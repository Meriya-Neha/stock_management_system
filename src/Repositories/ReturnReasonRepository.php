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
}

?>