<?php
namespace src\Controller;
use src\Services\PoOrderItemsService;
use src\Utils\Response;
use src\Utils\JwtHelper;
use Firebase\JWT\ExpiredException;

class PoOrderItemsController{
    private PoOrderItemsService $poorderitemsservice;
    private JwtHelper $jwtHelper;

    public function __construct()
    {
        $this->poorderitemsservice=new PoOrderItemsService();
        $this->jwtHelper = new JwtHelper();
    }

    public function create()
    {
        try {
            $user=$this->jwtHelper->check();
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

        // } catch (\Exception $e) {

        //     http_response_code(400);

        //     echo json_encode([
        //         "success" => false,
        //         "message" => $e->getMessage()
        //     ]);
        }
        catch (ExpiredException $e) {

    http_response_code(401);

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
            $user=$this->jwtHelper->check();
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
        catch (ExpiredException $e) {

    http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);

}
    }

    // GET BY ID
    public function getById(int $id): void
    {
        try {
            $user=$this->jwtHelper->check();
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
        catch (ExpiredException $e) {

    http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);

}
    }

    // PUT
    public function update(int $id): void
    {
        try {
            $user=$this->jwtHelper->check();
            $data = json_decode(file_get_contents("php://input"),true);
            print_r($data);

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
        catch (ExpiredException $e) {

    http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);

}
    }

    // DELETE
    public function delete(int $id): void
    {
        try {
            $user=$this->jwtHelper->check();
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
        catch (ExpiredException $e) {

    http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);

}
    }
}


?>