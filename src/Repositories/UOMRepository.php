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
}
