<?php
namespace src\Controller;
use src\Services\LocationService;
use src\Utils\Response;
class LocationController{
    private LocationService $locationService;

    public function __construct()
    {
        $this->locationService= new LocationService;
    }

    public function createLocation(){
        try{
        $body=json_decode(file_get_contents('php://input'),true);
        $result=$this->locationService->createLocation($body);
        Response::created('location added successfully',$result);

        }
        catch(\Throwable $e){
            throw new \Exception($e);
        }
    }

    public function getLocation(){
        try{
            $result=$this->locationService->getLocation();
            Response::success('data found successfully',$result);

        }
        catch(\Throwable $e){
            throw new \Exception($e);
        }
    }

}


?>