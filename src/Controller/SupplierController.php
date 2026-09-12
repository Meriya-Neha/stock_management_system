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

 // GET BY ID
    public function getById(int $id): void
    {
        try {

            $result = $this->supplierService->getById($id);

            Response::success(
                'Supplier fetched successfully.',
                $result
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Supplier not found') {
                Response::notFound($e->getMessage());
            }

            Response::badRequest($e->getMessage());
        }
    }

    // PUT
    public function update(int $id): void
    {
        try {

            $data = json_decode(
                file_get_contents("php://input"),
                true
            );

            if (!is_array($data)) {
                Response::badRequest('Invalid request data');
            }

            $result = $this->supplierService->update($id, $data);

            Response::success(
                'Supplier updated successfully.',
                $result
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Supplier not found') {
                Response::notFound($e->getMessage());
            }

            Response::badRequest($e->getMessage());
        }
    }

    // DELETE
    public function delete(int $id): void
    {
        try {

            $this->supplierService->delete($id);

            Response::success(
                'Supplier deleted successfully.'
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Supplier not found') {
                Response::notFound($e->getMessage());
            }

            Response::badRequest($e->getMessage());
        }
    }


}   

?>