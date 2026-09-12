<?php
namespace src\Repositories;
use src\config\Database;
use PDO;

class SupplierRepository{
    private \PDO $db;

    public function __construct()
    {
        $this->db=Database::getConnection();
    }
    public function createSupplier($data)
    {
        print_r($data['GST_no']);

        try{
        $query="INSERT INTO supplier
        (
            company_name,
            phone_no,
            alternate_phone_no,
            email,
            pincode,
            address,
            city,
            state,
            country,
            GST_no
        )
        VALUES
        (
           :company_name,
            :phone_no,
            :alternate_phone_no,
            :email,
            :pincode,
            :address,
            :city,
            :state,
            :country,
            :GST_no 
        )";
        $stmt=$this->db->prepare($query);
        $stmt->execute([
                ':company_name'=>$data['company_name'],
                ':phone_no'=>$data['phone_no'],
                ':alternate_phone_no'=>$data['alternate_phone_no'],
                ':email'=>$data['email'],
                ':pincode'=>$data['pincode'],
                ':address'=>$data['address'],
                ':city'=>$data['city'],
                ':state'=>$data['state'],
                ':country'=>$data['country'],
                ':GST_no'=>$data['GST_no']

                ]);
            return true;  
        }
        catch(\Throwable $e){
            die($e->getMessage());
            return false;
        }  
    }

    public function getSupplier():array
    {
        $query="SELECT * FROM supplier";
        try{
            $stmt=$this->db->prepare($query);
            $stmt->execute();
            $results=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }
        catch(\Throwable $e){
            die($e->getMessage());
            return [];
        }
    }
    public function deleteSupplier($id)
    {
        try{
            $query="DELETE FROM supplier WHERE id=:id";
            $stmt=$this->db->prepare($query);
            $stmt->execute([
                ':id'=>$id
            ]);
            return true;
        }
        catch(\Throwable $e){
            die($e->getMessage());
            return false;
        }
    }
     // GET BY ID
    public function getById(int $id): ?array
    {
        $sql = "SELECT
                    id,
                    company_name,
                    phone_no,
                    alternate_phone_no,
                    email,
                    pincode,
                    address,
                    city,
                    state,
                    country,
                    GST_no
                FROM supplier
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
        $sql = "UPDATE supplier
                SET
                    company_name = :company_name,
                    phone_no = :phone_no,
                    alternate_phone_no = :alternate_phone_no,
                    email = :email,
                    pincode = :pincode,
                    address = :address,
                    city = :city,
                    state = :state,
                    country = :country,
                    GST_no = :GST_no
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':company_name' => $data['company_name'],
            ':phone_no' => $data['phone_no'],
            ':alternate_phone_no' => $data['alternate_phone_no'] ?? null,
            ':email' => $data['email'],
            ':pincode' => $data['pincode'],
            ':address' => $data['address'],
            ':city' => $data['city'],
            ':state' => $data['state'],
            ':country' => $data['country'],
            ':GST_no' => $data['GST_no'] ?? null,
            ':id' => $id
        ]);

        return $this->getById($id);
    }

    // DELETE
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM supplier
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->rowCount() > 0;
    }
   
}
// {
//   "company_name": "Apex Global Logistics Pvt Ltd",
//   "phone_no": "98765 43210",
//   "alternate_phone_no":"98765 43210",
//   "email": "contact@apexlogistics.com",
//   "pincode": "360001",
//   "address": "102, Business Hub, Kalawad Road",
//   "city": "Rajkot",
//   "state": "Gujarat",
//   "country": "India",
//   "GST_no": "24AAAAA0000A1Z5"
// }