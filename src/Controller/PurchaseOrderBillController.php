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

    // public function createPurchaseOrderBill()
    // {
    //     try {

    //         // Normal form fields
    //         $input = $_POST;

    //         // Uploaded file/image
    //         $file = $_FILES['file'] ?? null;

    //         $response = $this->purchaseOrderBillService
    //             ->createPurchaseOrderBill(
    //                 $input,
    //                 $file
    //             );

    //         Response::created(
    //             'Purchase Order Bill Created',
    //             $response
    //         );

    //     } catch (\Throwable $e) {

    //         die($e->getMessage());
    //     }
    // }
    public function createPurchaseOrderBill()
    {
        try {

            $input = $_POST;

            $file = $_FILES['file'] ?? null;

            $response = $this->purchaseOrderBillService
                ->createPurchaseOrderBill(
                    $input,
                    $file
                );

            Response::created(
                'Purchase Order Bill Created',
                $response
            );
        } catch (\Throwable $e) {

            die($e->getMessage());
        }
    }
}
