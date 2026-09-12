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
    public function getAll(): void
    {
        try {

            $result = $this->purchaseOrderBillService->getAll();

            Response::success(
                'Purchase order bills fetched successfully.',
                $result
            );

        } catch (\Exception $e) {

            Response::internalError(
                'Failed to fetch purchase order bills.'
            );
        }
    }

    // GET BY ID
    public function getById(int $id): void
    {
        try {

            $result = $this->purchaseOrderBillService->getById($id);

            Response::success(
                'Purchase order bill fetched successfully.',
                $result
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Purchase order bill not found') {
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

            $result = $this->purchaseOrderBillService->update($id, $data);

            Response::success(
                'Purchase order bill updated successfully.',
                $result
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Purchase order bill not found') {
                Response::notFound($e->getMessage());
            }

            Response::badRequest($e->getMessage());
        }
    }

    // DELETE
    public function delete(int $id): void
    {
        try {

            $this->purchaseOrderBillService->delete($id);

            Response::success(
                'Purchase order bill deleted successfully.'
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Purchase order bill not found') {
                Response::notFound($e->getMessage());
            }

            Response::badRequest($e->getMessage());
        }
    }

}
