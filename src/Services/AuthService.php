<?php

namespace src\Services;

use Exception;
use src\validation\validation;
use src\Repositories\AuthRepository;
use src\Utils\Response;
use Throwable;

class AuthService
{
    private validation $validation;
    private AuthRepository $authRepository;
    public function __construct()
    {
        $this->validation = new validation;
        $data = $this->authRepository = new AuthRepository;
    }
    public function authLogin(array $data):void
    {
        try {
            print_r($data);
            $validate=$this->validation->AuthValidation($data);
            $login = $this->authRepository->authLogin($data);
            print_r($login);
            $raw_pass=$data['password'];
            $hash_pass=$login[0]['password'];
            $verify=password_verify($raw_pass,$hash_pass);
            if($verify){
                echo ("passsword  correct");
            }
            else{
                throw new Exception("Incorrect passwod");
            } 
        }
        catch (Throwable $e) {
            Response::unauthorized('unauthorizes user');
        }
    }
}
