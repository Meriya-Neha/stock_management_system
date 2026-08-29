<?php
namespace src\Controller;

use src\Services\AuthService;
use src\Utils\Response;
use Throwable;

class AuthController{
    private AuthService $authService;
    public function __construct()
    {
        $this->authService=new AuthService();
    }

    public function authLogin(){
        try{
        $body=json_decode(file_get_contents('php://input'),true)?? [];
        $result=$this->authService->authLogin($body);
        Response::send(200,'User Login Successfully',$result);
        }
        catch(Throwable $e){
            die($e->getMessage());
        }



    }
}

?>