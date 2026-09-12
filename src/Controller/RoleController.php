<?php
namespace src\Controller;
use src\Services\RoleService;
use src\Utils\Response;

class RoleController
{
    private RoleService $roleService;

    public function __construct()
    {
        $this->roleService = new RoleService();
    }

    public function createRole()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true) ?? [];
            $response = $this->roleService->createRole($input);
            Response::created('Role Created', $response);
        } catch (\Throwable $e) {
            die($e->getMessage());
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