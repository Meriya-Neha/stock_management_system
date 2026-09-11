<?php
namespace src\Controller;
use src\Services\PurchaseOrderBillService;
use src\Utils\Response;

class PurchaseOrderBillController
{
    private PurchaseOrderBillService $purchaseOrderBillService;
    public function __construct()
    {
        $this->purchaseOrderBillService = new PurchaseOrderBillService();
    }
    public function createPurchaseOrderBill()
    {
    try {
        $input=$_POST;
        $file=$FILES['file'] ?? null;
        $body = json_decode(file_get_contents('php://input'), true) ?? [];
        // $input = json_decode($rawInput, true) ?? [];
        $fileData = $body['document'] ?? null;
        unset($body['file']);
        $response = $this->purchaseOrderBillService->createPurchaseOrderBill($body,$fileData);
        Response::created('Purchase Order Bill Created', $response);
    }
    catch (\Throwable $e) {
            die($e->getMessage());
        }
    }
}
?>