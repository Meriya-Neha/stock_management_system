<?php
namespace src\Services;
use src\Repositories\PurchaseOrderBillRepository;

class PurchaseOrderBillService
{
    private PurchaseOrderBillRepository $purchaseOrderBillRepository;

    public function __construct()
    {
        $this->purchaseOrderBillRepository = new PurchaseOrderBillRepository();
    }

    public function createPurchaseOrderBill(array $data)
    {   
        print_r($data);
        try{
            $result = $this->purchaseOrderBillRepository->createPurchaseOrderBill($data);
            return $result;
        }
        catch(\Throwable $e){
            throw new \Exception("Failed to create purchase order bill: " . $e->getMessage());
        }
       
    }

}

?>