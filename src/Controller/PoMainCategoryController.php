<?php
namespace src\Controller;
use src\Services\PoMainCategoryService;
use src\Utils\Response;
class PoMainCategoryController
{
    private PoMainCategoryService $poMainCategoryService;
    public function __construct()
    {
        $this->poMainCategoryService = new PoMainCategoryService();
    }

    public function createPoMainCategory()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true) ?? [];
            $response = $this->poMainCategoryService->createPoMainCategory($input);
            Response::created('PO Main Category Created', $response);
        } catch (\Throwable $e) {
            die($e->getMessage());
        }
    }
}



?>