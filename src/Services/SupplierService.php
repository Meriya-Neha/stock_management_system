<?php
namespace src\Services;
use src\Repositories\SupplierRepository;
use src\Validation\validation;
use src\Utils\Response;
use Throwable;


class SupplierService{
    private $supplierRepository;
    private $validation;
    public function __construct()   
    {
        $this->supplierRepository=new SupplierRepository();
        $this->validation=new validation();
    }
    public function createSupplier($data)
    {
        try{
            if(empty($data['company_name']) || empty($data['phone_no']) || empty($data['email']) || empty($data['pincode']) || empty($data['address']) || empty($data['city']) || empty($data['state']) || empty($data['country']) || empty($data['GST_no'])){
                throw new \Exception('All fields are required');
            }
            $valudationResult = $this->validation->SupplierValidation($data);
            if (!empty($valudationResult)) {
                 Response::badRequest(  "VALIDATION ERROR", $valudationResult);
            }
            $result = $this->supplierRepository->createSupplier($data);

        }
        catch (Throwable $e) {
            die ($e); 
        }
        // return $result;
    }

    public function getSupplier()
    {
        try{
            $result=$this->supplierRepository->getSupplier();
            return $result;
        }
        catch (Throwable $e) {
            echo ($e); 
        }
    }

    public function deleteSupplier($id)
    {
        try{
            if(empty($id)){
                throw new \Exception('ID is required');
            }
            $result=$this->supplierRepository->deleteSupplier($id);
            return $result;
        }
        catch (Throwable $e) {
            echo ($e); 
        }
    }

}
?>