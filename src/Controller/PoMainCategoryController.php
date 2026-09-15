<?php
namespace src\Controller;
use src\Services\PoMainCategoryService;
use src\Utils\Response;
use src\Utils\JwtHelper;
use Firebase\JWT\ExpiredException;
class PoMainCategoryController
{
    private PoMainCategoryService $poMainCategoryService;
    private JwtHelper $jwtHelper;
    public function __construct()
    {
        $this->poMainCategoryService = new PoMainCategoryService();
        $this->jwtHelper=new JwtHelper();
    }

    public function createPoMainCategory()
    {
        try {
            $user=$this->jwtHelper->check();
            $input = json_decode(file_get_contents('php://input'), true) ?? [];
            $response = $this->poMainCategoryService->createPoMainCategory($input);
            Response::created('PO Main Category Created', $response);
        } catch (\Throwable $e) {
            die($e->getMessage());
        }
        catch (ExpiredException $e) {

    http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);

}
    }

    public function getPoMainCategory()
    {
        try {
            $user=$this->jwtHelper->check();
            $response = $this->poMainCategoryService->getPoMainCategory();
            Response::success('PO Main Category Retrieved', $response);
        // } catch (\Throwable $e) {
        //     die($e->getMessage());
        }
        catch (ExpiredException $e) {

    http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);

}
    }

     public function getById(int $id): void
    {
        try {
            $user=$this->jwtHelper->check();
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