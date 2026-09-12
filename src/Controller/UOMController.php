<?php
namespace src\Controller;
use src\Services\UOMService;
use src\Utils\Response;
use throwable;

class UOMController
{
    private UOMService $uomService;
    
    public function __construct()
    {
        $this->uomService = new UOMService;
    }
    public function createUOM()
    {
        try {
            $data=json_decode(file_get_contents('php://input'), true);
            $result = $this->uomService->createUOM($data);
            Response::created('UOM Created', $result);
        } catch (Throwable $e) {
            throw new \Exception($e);
        }
       
    }

    public function getUOM()
    {
        try{
            $result=$this->uomService->getUOM();
            Response::success('data found successfully',$result);
        }
        catch(\Throwable $e){
            throw new \Exception($e);

        }
    }
}

?>