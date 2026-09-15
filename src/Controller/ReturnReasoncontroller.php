<?php
namespace src\Controller;
use src\Services\ReturnReasonService;
use src\Utils\Response;
use src\Utils\JwtHelper;
use Firebase\JWT\ExpiredException;

class ReturnReasoncontroller{
    private ReturnReasonService $service;
    private JwtHelper $jwtHelper;

    public function __construct()
    {
        $this->service=new ReturnReasonService();
        $this->jwtHelper=new JwtHelper();
    }

    public function create()
    {
        try{
            $user=$this->jwtHelper->check();
            $input=json_decode(file_get_contents('php://input'),true) ?? [];
            $response=$this->service->create($input);
            Response::created('Return reason added successfully.',$response);

        }
        catch(\Exception $e){
            $mesage=$e->getMessage();
            Response::badRequest($mesage,[]);
        }
        catch (ExpiredException $e) {

    http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);

}
    }
    

    public function getAll()
    {
        try{
            $user=$this->jwtHelper->check();
            $response=$this->service->getAll();
            Response::success('data display successfully',$response);
        }
        catch(\Throwable $e){
            die($e->getMessage());
        }
    }
     public function getById(int $id): void
    {
        try {

            $result = $this->service->getById($id);

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

            $result = $this->service->update($id, $data);

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
            $this->service->delete($id);

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