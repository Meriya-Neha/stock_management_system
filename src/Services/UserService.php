<?php

namespace src\Services;

use src\Repositories\UserRepository;
use src\Validation\validation;
use Throwable;
use src\Utils\RateLimiter;

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
            $username=$data['email'];
            RateLimiter::check('/user/add',$username);
            $this->validation->UserValidation($data);
            $hash_pass=password_hash($data['password'],PASSWORD_DEFAULT);
            $data['password']=$hash_pass;
            $this->userRepository->creteUser($data);
        } catch (Throwable $e) {
            echo ($e); 
        }
    }
}
