<?php
namespace src\Repositories;
use src\config\Database;
use Throwable;
use PDO;
use PDOException;

class BussinessTypeRepository{
    private \PDO $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    public function bussinessAdd($data)
    {
        $query="INSERT INTO bussiness_type (bussines_type,configuration) VALUES (:bussines_type, :configuration)";
        try{
            $stmt=$this->db->prepare($query);
            $stmt->execute([
                ':bussines_type' => $data['bussines_type'] ,
                ':configuration' => $data['configuration']?? null,
            ]);
            return true;
        }
        catch(Throwable $e){
            die($e->getMessage());
            return false;
        }
    }
    // public function bussinessGet():array{
    //     $query="select * from bussiness_type";
    //     try{
    //     $stmt = $this->db->prepare($query);
    //         // $stmt->execute([$limit, $offset]);
            
    //         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //         print_r($results);
    //         return $results;
            
    //     } catch (PDOException $e) {
    //         die($e);
    //     }
    // }
    public function bussinessGet(): array
{
    $query = "SELECT * FROM bussiness_type";

    try {

        $stmt = $this->db->prepare($query);

        // Query ko database mein run karo
        $stmt->execute();

        // Database se result nikalo
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;

    } catch (PDOException $e) {

        die($e->getMessage());
    }
}
}
?>