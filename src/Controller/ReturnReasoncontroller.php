<?php
namespace src\Controller;
use src\Services\ReturnReasonService;
use src\Utils\Response;

class ReturnReasoncontroller{
    private ReturnReasonService $service;

    public function __construct()
    {
        $this->service=new ReturnReasonService();
    }

    public function create()
    {
        try{
            $input=json_decode(file_get_contents('php://input'),true) ?? [];
            $response=$this->service->create($input);
            Response::created('Return reason added successfully.',$response);

        }
        catch(\Exception $e){
            $mesage=$e->getMessage();
            Response::badRequest($mesage,[]);
        }
    }

    public function getAll()
    {
        try{
            $response=$this->service->getAll();
            Response::success('data display successfully',$response);
        }
        catch(\Throwable $e){
            die($e->getMessage());
        }
    }

}

?>