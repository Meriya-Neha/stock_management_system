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

    // GET BY ID
    public function getById(int $id): array
    {
        if ($id <= 0) {
            throw new \Exception('Invalid supplier ID');
        }

        $supplier = $this->supplierRepository->getById($id);

        if (!$supplier) {
            throw new \Exception('Supplier not found');
        }

        return $supplier;
    }

    // UPDATE
    public function update(int $id, array $data): array
    {
        // Check supplier exists
        $this->getById($id);

        if (empty($data['company_name'])) {
            throw new \Exception('company_name is required');
        }

        if (empty($data['phone_no'])) {
            throw new \Exception('phone_no is required');
        }

        if (empty($data['email'])) {
            throw new \Exception('email is required');
        }

        if (empty($data['pincode'])) {
            throw new \Exception('pincode is required');
        }

        if (empty($data['address'])) {
            throw new \Exception('address is required');
        }

        if (empty($data['city'])) {
            throw new \Exception('city is required');
        }

        if (empty($data['state'])) {
            throw new \Exception('state is required');
        }

        if (empty($data['country'])) {
            throw new \Exception('country is required');
        }

        return $this->supplierRepository->update($id, [
            'company_name' => trim($data['company_name']),
            'phone_no' => trim($data['phone_no']),
            'alternate_phone_no' => !empty($data['alternate_phone_no'])
                ? trim($data['alternate_phone_no'])
                : null,
            'email' => trim($data['email']),
            'pincode' => trim($data['pincode']),
            'address' => trim($data['address']),
            'city' => trim($data['city']),
            'state' => trim($data['state']),
            'country' => trim($data['country']),
            'GST_no' => !empty($data['GST_no'])
                ? trim($data['GST_no'])
                : null
        ]);
    }

    // DELETE
    public function delete(int $id): void
    {
        // Check supplier exists
        $this->getById($id);

        $deleted = $this->supplierRepository->delete($id);

        if (!$deleted) {
            throw new \Exception('Failed to delete supplier');
        }
    }
}
?>