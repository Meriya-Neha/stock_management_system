<?php

namespace src\Controller;
use src\Services\UserService;
use src\Utils\Response;
use Throwable;

class UserController{
    private UserService  $userService;
    public function __construct()
    {
        $this->userService=new UserService();
    }

    public function createUser():void
    {
        try{
            $body=json_decode(file_get_contents('php://input'),true)?? [];
            // $result=$this->userService->creteUser($body);
            $result = $this->userService->creteUser($body);
            Response::created('User Creted Successfully',$result);
        }
        catch(Throwable $e){
            echo($e);
        }
    }
    

}

?>