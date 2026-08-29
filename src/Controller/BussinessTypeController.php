<?php
namespace src\Controller;
use src\Services\BussinessTypeService;
use src\Utils\Response;
use Throwable;

class BussinessTypeController{
    private BussinessTypeService $bussinessTypeService;

    public function __construct()
    {
        $this->bussinessTypeService=new BussinessTypeService();
    } 
    
    public function bussinessAdd(){
        try{
        $body=json_decode(file_get_contents('php://input'),true) ?? [];
        $result=$this->bussinessTypeService->bussinessAdd($body);
        Response::created('Bussiness Type Created',$result);
        }
        catch(Throwable $e)
        {
            echo ($e);
        }
    }
    public function bussinessGet():array{
    try{
        $result=$this->bussinessTypeService->bussinessGet();
        Response::success('User Found Successfully',$result);
    }
    catch(Throwable $e){
        echo($e);
    }
    return $result;
    }

}


?>