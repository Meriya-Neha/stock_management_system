<?php
namespace src\Controller;
use src\Services\UOMService;
use src\Utils\Response;
use throwable;

class UOMController
{
    private UOMService $uomService;
    
    public function __construct()
    {
        $this->uomService = new UOMService;
    }
    public function createUOM()
    {
        try {
            $data=json_decode(file_get_contents('php://input'), true);
            $result = $this->uomService->createUOM($data);
            Response::created('UOM Created', $result);
        } catch (Throwable $e) {
            throw new \Exception($e);
        }
       
    }

    public function getUOM()
    {
        try{
            $result=$this->uomService->getUOM();
            Response::success('data found successfully',$result);
        }
        catch(\Throwable $e){
            throw new \Exception($e);

        }
    }
     public function getById(int $id): void
    {
        try {

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
    }

    // DELETE
    public function delete(int $id): void
    {
        try {

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
    }
}

?>