<?php
namespace src\Services;
use src\Repositories\LocationRepository;


class LocationService{
    private LocationRepository $locationRepository;

    public function __construct()
    {
        $this->locationRepository=new LocationRepository;
    }
    public function createLocation(array $data){
        return $this->locationRepository->createLocation($data);

    }

    public function getLocation(){
        return $this->locationRepository->getLocation();
    }
}
?>