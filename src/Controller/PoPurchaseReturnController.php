<?php

namespace src\Controller;

use src\Services\PoPurchaseReturnService;
use src\Utils\Response;

class PoPurchaseReturnController
{
    private PoPurchaseReturnService $service;
    public function __construct()
    {
        $this->service = new PoPurchaseReturnService();
    }
    public function createPurchaseReturn()
    {
        try {

            $input = json_decode(file_get_contents("php://input"), true);
            if (!$input) {
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid request data."
                ], 400);
            }
            $result = $this->service
                ->createPurchaseReturn($input);
            echo json_encode([
                "success" => true,
                "message" => "Purchase return created successfully.",
                "data" => $result
            ], 201);
        } catch (\Exception $e) {
            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function getAll(): void
    {
        try {

            $returns = $this->service->getAll();
            Response::success('Purchase returns fetched successfully.', $returns);
        } catch (\Exception $e) {

            die($e->getMessage());
        }
    }
    public function getById(int $id): void
{
    try {

        if ($id <= 0) {
            Response::badRequest(
                'Invalid purchase return ID.'
            );
        }

        $return = $this->service
                       ->getById($id);

        Response::success(
            'Purchase return fetched successfully.',
            $return
        );

    } catch (\Exception $e) {

        Response::notFound(
            $e->getMessage()
        );
    }
}
}
