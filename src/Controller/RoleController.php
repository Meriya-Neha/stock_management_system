<?php
namespace src\Controller;
use src\Services\RoleService;
use src\Utils\Response;
use src\Utils\JwtHelper;
use Firebase\JWT\ExpiredException;

class RoleController
{
    private RoleService $roleService;
    private JwtHelper $jwtHelper;


    public function __construct()
    {
        $this->roleService = new RoleService();
        $this->jwtHelper = new JwtHelper();
    }

    public function createRole()
    {
        try {
            $user=$this->jwtHelper->check();
            $input = json_decode(file_get_contents('php://input'), true) ?? [];
            $response = $this->roleService->createRole($input);
            Response::created('Role Created', $response);
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

    public function getRoles()
    {
        try {
            $response = $this->roleService->getRoles();
            Response::success('Roles Retrieved', $response);
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

    // public function updateRole()
    // {
    //     try{
    //         $input = json_decode(file_get_contents('php://input'), true) ?? [];
    //         $response = $this->roleService->updateRole($input);
    //         Response::success('Role Updated', $response);
    //     } catch (\Throwable $e) {
    //         die($e->getMessage());
    //     }
    // }
}
?>