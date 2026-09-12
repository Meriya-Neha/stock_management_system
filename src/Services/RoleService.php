<?php
namespace src\Services;
use src\Repositories\RoleRepository;

class RoleService
{
    private RoleRepository $roleRepository;

    public function __construct()
    {
        $this->roleRepository = new RoleRepository();
    }

    public function createRole(array $data)
    {
        return $this->roleRepository->create($data);
    }

    public function getRoles()
    {
        return $this->roleRepository->getAll();
    }

    // public function updateRole(array $data)
    // {
    //     return $this->roleRepository->update($data);
    // }
}
?>