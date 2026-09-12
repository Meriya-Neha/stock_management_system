<?php
namespace src\Controller;
use src\Services\BussinessTypeService;
use src\Utils\Response;
use Throwable;

class BussinessTypeController{
    private BussinessTypeService $bussinessTypeService;

    public function __construct()
    {
        $this->bussinessTypeService=new BussinessTypeService();
    } 
    
    public function bussinessAdd(): void
    {
        try{
        $body=json_decode(file_get_contents('php://input'),true) ?? [];
        $result=$this->bussinessTypeService->bussinessAdd($body);
        Response::created('Bussiness Type Created',$result);
        return;
        }
        catch(Throwable $e)
        {
            echo ($e);
            // return [];
        }
    }
    public function bussinessGet():array{
    try{
        $result=$this->bussinessTypeService->bussinessGet();
        Response::success('User Found Successfully',$result);
    }
    catch(Throwable $e){
        echo($e);
    }
    return $result;
    }
     public function getById(int $id): void
    {
        try {

            $result = $this->bussinessTypeService->getById($id);

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

            $result = $this->bussinessTypeService->update($id, $data);

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

            $this->bussinessTypeService->delete($id);

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