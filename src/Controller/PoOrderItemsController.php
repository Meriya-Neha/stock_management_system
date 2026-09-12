<?php
namespace src\Controller;
use src\Services\PoOrderItemsService;
use src\Utils\Response;

class PoOrderItemsController{
    private PoOrderItemsService $poorderitemsservice;

    public function __construct()
    {
        $this->poorderitemsservice=new PoOrderItemsService();
    }

    public function create()
    {
        try {

            $input = json_decode(file_get_contents("php://input"), true);

            if (!is_array($input)) {
                throw new \Exception("Invalid JSON data");
            }

            $result = $this->poorderitemsservice->create($input);

            http_response_code(201);

            echo json_encode([
                "success" => true,
                "message" => "Product added successfully",
                "data" => $result
            ]);

        } catch (\Exception $e) {

            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    // GET ALL
    public function getAll(): void
    {
        try {

            $result = $this->poorderitemsservice->getAll();

            Response::success(
                'Purchase order items fetched successfully.',
                $result
            );

        } catch (\Exception $e) {

            Response::internalError(
                'Failed to fetch purchase order items.'
            );
        }
    }

    // GET BY ID
    public function getById(int $id): void
    {
        try {

            $result = $this->poorderitemsservice->getById($id);

            Response::success(
                'Purchase order item fetched successfully.',
                $result
            );

        } catch (\Exception $e) {

            if (
                $e->getMessage() ===
                'Purchase order item not found'
            ) {
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

            $result = $this->poorderitemsservice->update($id, $data);

            Response::success(
                'Purchase order item updated successfully.',
                $result
            );

        } catch (\Exception $e) {

            if (
                $e->getMessage() ===
                'Purchase order item not found'
            ) {
                Response::notFound($e->getMessage());
            }

            Response::badRequest($e->getMessage());
        }
    }

    // DELETE
    public function delete(int $id): void
    {
        try {

            $this->poorderitemsservice->delete($id);

            Response::success(
                'Purchase order item deleted successfully.'
            );

        } catch (\Exception $e) {

            if (
                $e->getMessage() ===
                'Purchase order item not found'
            ) {
                Response::notFound($e->getMessage());
            }

            Response::badRequest($e->getMessage());
        }
    }
}


?>