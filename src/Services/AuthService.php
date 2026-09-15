<?php

namespace src\Services;
use Dotenv\Dotenv;
use Exception;
use src\validation\validation;
use src\Repositories\AuthRepository;
use src\Utils\Response;
use src\Utils\JwtHelper;
require_once __DIR__ . '/../../vendor/autoload.php';

use Throwable;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

use Firebase\JWT\JWT;


class AuthService
{
    private validation $validation;
    private AuthRepository $authRepository;
    private JwtHelper $jwtHelper;
    public function __construct()
    {
        $this->jwtHelper= new JwtHelper;
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
                throw new Exception("Incorrect passwod");
                Response::unauthorized('unauthorizes user');
            }
            $jwt_access=$this->jwtHelper->generateAccessToken($login[0]);
            $jwt_refresh=$this->jwtHelper->generateRefreshToken($login[0]);

        }
        catch (Throwable $e) {
            Response::unauthorized('unauthorizes user');
            echo ($e);
        }

        return [    
            'access_token'=>$jwt_access,
            'refresh_token'=>$jwt_refresh,
            'user_data'=>$login[0]
        ];
    }
}
