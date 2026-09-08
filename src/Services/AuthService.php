<?php

namespace src\Services;
use Dotenv\Dotenv;
use Exception;
use src\validation\validation;
use src\Repositories\AuthRepository;
use src\Utils\Response;
require_once __DIR__ . '/../../vendor/autoload.php';

use Throwable;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

use Firebase\JWT\JWT;


class AuthService
{
    private validation $validation;
    private AuthRepository $authRepository;
    public function __construct()
    {
        $this->validation = new validation;
        $this->authRepository = new AuthRepository;
    }
    public function authLogin(array $data):array
    {
        try {
            // print_r($data);
            $validate=$this->validation->AuthValidation($data);
            $login = $this->authRepository->authLogin($data);
            // print_r($login);
            $raw_pass=$data['password'];
            $hash_pass=$login[0]['password'];
            $verify=password_verify($raw_pass,$hash_pass);
            if($verify){
                // echo ("passsword  correct");
            }
            else{
                // throw new Exception("Incorrect passwod");
                // Response::unauthorized('unauthorizes user');
            }
            $jwt_access = $_ENV['jwt_access'];
            $issue = time();
            $expire = $issue + 3600; 

            $payload = [
                'iat'=>$issue,
                'exp'=>$expire,
                'user_id'=>$login[0]['id'],
                'user_email'=>$login[0]['email']
            ];

            $token=JWT::encode($payload,$jwt_access,'HS256');
            // echo ($token);

            $jwt_refresh = $_ENV['jwt_refresh'];
            // $payload_refresh = [
            //     'iat'=>$issue,
            //     'exp'=>$expire + 604800, 
            //     'user_id'=>$login[0]['id'],
            //     'user_email'=>$login[0]['email']
            // ];
            $refresh_token=JWT::encode($payload,$jwt_refresh,'HS256');
            // echo ($refresh_token);
        }
        catch (Throwable $e) {
            Response::unauthorized('unauthorizes user');
            echo ($e);
        }

        return [    
            'access_token'=>$token,
            'refresh_token'=>$refresh_token,
            'user_data'=>$data
        ];
    }
}
