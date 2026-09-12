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

    public function getAll(){
        
    }
}


?>