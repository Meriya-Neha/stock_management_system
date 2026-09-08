<?php
namespace src\Repositories;
use Throwable;
use src\config\Database;
use PDO;
 

class AuthRepository{
     private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    public function authLogin(array $data)
    {
        // echo("repository");
        // print_r($data);
        $query="select * from users where email=:email";

        try{
            $stmt=$this->db->prepare($query);
            $stmt->execute([
                ':email'=>$data['email']
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(Throwable $e){
            error_log($e->getMessage());
            return false;
        }
    }
}

?>