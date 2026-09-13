<?php
// namespace src\Controller;
// use src\Services\LocationService;
// use src\Utils\Response;
// class LocationController{
//     private LocationService $locationService;

//     public function __construct()
//     {
//         $this->locationService= new LocationService;
//     }

//     public function createLocation(){
//         try{
//         $body=json_decode(file_get_contents('php://input'),true);
//         $result=$this->locationService->createLocation($body);
//         Response::created('location added successfully',$result);

//         }
//         catch(\Throwable $e){
//             throw new \Exception($e);
//         }
//     }

//     public function getLocation(){
//         try{
//             $result=$this->locationService->getLocation();
//             Response::success('data found successfully',$result);

//         }
//         catch(\Throwable $e){
//             throw new \Exception($e);
//         }
//     }
//      public function getById(int $id): void
//     {
//         try {

//             $result = $this->locationService->getById($id);

//             Response::success(
//                 'Category fetched successfully.',
//                 $result
//             );

//         } catch (\Exception $e) {

//             if ($e->getMessage() === 'Category not found') {
//                 Response::notFound($e->getMessage());
//             }

//             Response::badRequest($e->getMessage());
//         }
//     }

//     // PUT
//     public function update(int $id): void
//     {
//         try {

//             $data = json_decode(
//                 file_get_contents("php://input"),
//                 true
//             );

//             if (!is_array($data)) {
//                 Response::badRequest('Invalid request data');
//             }

//             $result = $this->locationService->update($id, $data);

//             Response::success(
//                 'Category updated successfully.',
//                 $result
//             );

//         } catch (\Exception $e) {

//             if ($e->getMessage() === 'Category not found') {
//                 Response::notFound($e->getMessage());
//             }

//             Response::badRequest($e->getMessage());
//         }
//     }

//     // DELETE
//     public function delete(int $id): void
//     {
//         try {

//             $this->locationService->delete($id);

//             Response::success(
//                 'Category deleted successfully.'
//             );

//         } catch (\Exception $e) {

//             if ($e->getMessage() === 'Category not found') {
//                 Response::notFound($e->getMessage());
//             }

//             Response::badRequest($e->getMessage());
//         }
//     }

// }

namespace src\Controller;

use src\Services\LocationService;
use src\Utils\Response;
use src\Utils\JwtHelper;

class LocationController
{
    private LocationService $locationService;
    private  JwtHelper $jwtHelper;

    public function __construct()
    {
        $this->locationService = new LocationService();
        $this->jwtHelper = new JwtHelper();
    }

    public function createLocation()
    {
        try {

            // JWT CHECK
            $user = $this->jwtHelper->check();

            $body = json_decode(
                file_get_contents('php://input'),
                true
            );

            $result = $this->locationService
                ->createLocation($body);

            Response::created(
                'location added successfully',
                $result
            );

        } catch (\Throwable $e) {

            throw new \Exception($e);
        }
    }

    public function getLocation()
    {
        try {

            // JWT CHECK
            $user = $this->jwtHelper->check();

            $result = $this->locationService
                ->getLocation();

            Response::success(
                'data found successfully',
                $result
            );

        } catch (\Throwable $e) {

            throw new \Exception($e);
        }
    }

    public function getById(int $id): void
    {
        try {

            // JWT CHECK
            $user = $this->jwtHelper->check();
            print_r($user);

            $result = $this->locationService
                ->getById($id);

            Response::success(
                'Location fetched successfully.',
                $result
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Location not found') {
                Response::notFound($e->getMessage());
            }

            Response::badRequest($e->getMessage());
        }
    }

    public function update(int $id): void
    {
        try {

            // JWT CHECK
            $user = $this->jwtHelper->check();

            $data = json_decode(
                file_get_contents("php://input"),
                true
            );

            if (!is_array($data)) {
                Response::badRequest('Invalid request data');
            }

            $result = $this->locationService
                ->update($id, $data);

            Response::success(
                'Location updated successfully.',
                $result
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Location not found') {
                Response::notFound($e->getMessage());
            }

            Response::badRequest($e->getMessage());
        }
    }

    public function delete(int $id): void
    {
        try {

            // JWT CHECK
            $user = $this->jwtHelper->check();

            $this->locationService->delete($id);

            Response::success(
                'Location deleted successfully.'
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Location not found') {
                Response::notFound($e->getMessage());
            }
            Response::badRequest($e->getMessage());
        }
    }
}

?>