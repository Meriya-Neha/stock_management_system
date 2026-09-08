<?php
namespace src\Controller;
use src\Services\SupplierService;
use src\Utils\Response;
use Throwable;

class SupplierController{
    private SupplierService $supplierService;
    public function __construct()
    {
        $this->supplierService=new SupplierService();
    }

    public function createSupplier():void
    {
        try{
            $body=json_decode(file_get_contents('php://input'),true) ?? [];
            $result=$this->supplierService->createSupplier($body);
            Response::created('Supplier Created',$result);
        } catch (\Throwable $e) {
            die($e->getMessage());
        }
    }

    public function getSupplier():array
    {
        try{
            $result=$this->supplierService->getSupplier();
            Response::success('Supplier Found Successfully',$result);
        } catch (\Throwable $e) {
            die($e->getMessage());
        }
        return $result;
    }

    public function deleteSupplier($id):void
    {
        try{
            $body=json_decode(file_get_contents('php://input'),true) ?? [];
            $result=$this->supplierService->deleteSupplier($body);
            Response::success('Supplier Deleted Successfully',$result);
        } catch (\Throwable $e) {
            die($e->getMessage());
        }
    }


}   

?>