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

    public function getPoMainCategory()
    {
        try {
            $response = $this->poMainCategoryService->getPoMainCategory();
            Response::success('PO Main Category Retrieved', $response);
        } catch (\Throwable $e) {
            die($e->getMessage());
        }
    }

     public function getById(int $id): void
    {
        try {

            $result = $this->poMainCategoryService->getById($id);

            Response::success(
                'Category fetched successfully.',
                $result
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Category not found') {
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

            $result = $this->poMainCategoryService->update($id, $data);

            Response::success(
                'Category updated successfully.',
                $result
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Category not found') {
                Response::notFound($e->getMessage());
            }

            Response::badRequest($e->getMessage());
        }
    }

    // DELETE
    public function delete(int $id): void
    {
        try {

            $this->poMainCategoryService->delete($id);

            Response::success(
                'Category deleted successfully.'
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Category not found') {
                Response::notFound($e->getMessage());
            }

            Response::badRequest($e->getMessage());
        }
    }
}



?>