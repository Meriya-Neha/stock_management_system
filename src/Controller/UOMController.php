<?php
namespace src\Controller;
use src\Services\UOMService;
use src\Utils\Response;
use throwable;
use src\Utils\JwtHelper;
use Firebase\JWT\ExpiredException;

class UOMController
{
    private UOMService $uomService;
    private JwtHelper $jwtHelper;
    
    public function __construct()
    {
        $this->uomService = new UOMService;
        $this->jwtHelper = new JwtHelper;
    }
    public function createUOM()
    {
        try {
            $user=$this->jwtHelper->check();
            $data=json_decode(file_get_contents('php://input'), true);
            $result = $this->uomService->createUOM($data);
            Response::created('UOM Created', $result);
        } catch (Throwable $e) {
            throw new \Exception($e);
        }
        catch (ExpiredException $e) {

    http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);

}
       
    }

    public function getUOM()
    {
        try{
            $user=$this->jwtHelper->check();
            $result=$this->uomService->getUOM();
            Response::success('data found successfully',$result);
        }
        catch(\Throwable $e){
            throw new \Exception($e);

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
            $result = $this->uomService->getById($id);

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

            $result = $this->uomService->update($id, $data);

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
            $this->uomService->delete($id);

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