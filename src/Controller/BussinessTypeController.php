<?php
namespace src\Controller;
use src\Services\BussinessTypeService;
use src\Utils\Response;
use Throwable;
use src\Utils\JwtHelper;
use Firebase\JWT\ExpiredException;

class BussinessTypeController{
    private BussinessTypeService $bussinessTypeService;
    private JwtHelper $jwtHelper;
    public function __construct()
    {
        $this->bussinessTypeService=new BussinessTypeService();
        $this->jwtHelper= new JwtHelper();
    } 
    
    public function bussinessAdd(): void
    {
        try{
            $user=$this->jwtHelper->check();
            $body=json_decode(file_get_contents('php://input'),true) ?? [];
            $this->bussinessTypeService->bussinessAdd($body);
            Response::created('Bussiness Type Created');
        }
        catch(Throwable $e)
        {
            echo ($e);
        }
        catch (ExpiredException $e) {

    http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);

}
    }
    public function bussinessGet():void{
    try{
            $user=$this->jwtHelper->check();
        
        $result=$this->bussinessTypeService->bussinessGet();
        Response::success('User Found Successfully',$result);
    }
    catch(Throwable $e){
        echo($e);
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