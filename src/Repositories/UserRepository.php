<?php

namespace src\Repositories;

use Throwable;
use src\config\Database;

class UserRepository
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function creteUser($data)
    {
        print_r($data);
        // print_r($hash_pass);
        $query = "INSERT INTO users
        (
            role_id,
            full_name,
            email,
            password,
            phone_no,
            company_name,
            business_type_id,
            country_name,
            state_name,
            city_name,
            status
        )
        VALUES
        (
            :role_id,
            :full_name,
            :email,
            :password,
            :phone_no,
            :company_name,
            :business_type_id,
            :country_name,
            :state_name,
            :city_name,
            :status
        )";

        try {
            $stmt = $this->db->prepare($query);

            $stmt->execute([
                ':role_id' => $data['role_id'] ?? null,
                ':full_name' => $data['full_name'],
                ':email' => $data['email'],
                ':password' => $data['password'],
                ':phone_no' => $data['phone_no'],
                ':company_name' => $data['company_name'],
                ':business_type_id' => $data['business_type_id'],
                ':country_name' => $data['country_name'],
                ':state_name' => $data['state_name'],
                ':city_name' => $data['city_name'],
                ':status' => $data['status'] ?? 'active'
            ]);

            return true;

        } catch (Throwable $e) {        
            die($e->getMessage());
            return false;
        }
    }
}