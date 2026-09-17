<?php
namespace src\Controller;
use src\Services\SupplierService;
use src\Utils\Response;
use Throwable;
use src\Utils\JwtHelper;
use Firebase\JWT\ExpiredException;

class SupplierController{
    private SupplierService $supplierService;
    private JwtHelper $jwtHelper;
    public function __construct()
    {
        $this->supplierService=new SupplierService();
        $this->jwtHelper=new JwtHelper();
    }

    public function createSupplier():void
    {
        try{
            $user=$this->jwtHelper->check();
            $body=json_decode(file_get_contents('php://input'),true) ?? [];
            $this->supplierService->createSupplier($body);
            Response::created('Supplier Created');
        } catch (\Throwable $e) {
            die($e->getMessage());
        }
        catch (ExpiredException $e) {

    echo  $e->getMessage();
}
    }

    public function getSupplier():array
    {
        try{
            $user=$this->jwtHelper->check();
            $result=$this->supplierService->getSupplier();
            Response::success('Supplier Found Successfully',$result);
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
        return $result;
    }

 // GET BY ID
    public function getById(int $id): void
    {
        try {
            $user=$this->jwtHelper->check();
            $result = $this->supplierService->getById($id);

            Response::success(
                'Supplier fetched successfully.',
                $result
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Supplier not found') {
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

            $result = $this->supplierService->update($id, $data);

            Response::success(
                'Supplier updated successfully.',
                $result
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Supplier not found') {
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
            $this->supplierService->delete($id);

            Response::success(
                'Supplier deleted successfully.'
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Supplier not found') {
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