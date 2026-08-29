<?php

namespace src\Services;

use src\Repositories\UserRepository;
use src\Validation\validation;
use Throwable;

class UserService
{

    private UserRepository  $userRepository;
    private validation $validation;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->validation = new validation();
    }

    public function creteUser(array $data): void
    {
        try {
            print_r($data);
            print_r($data['password']);

            $this->validation->UserValidation($data);
            // $password=$data['passwod'];
            // print_r($password);
            $hash_pass=password_hash($data['password'],PASSWORD_DEFAULT);
            $data['password']=$hash_pass;
            $this->userRepository->creteUser($data);
        } catch (Throwable $e) {
            echo ($e); 
        }
    }
}
