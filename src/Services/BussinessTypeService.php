<?php

namespace src\Services;

use Respect\Validation\Validator;
use src\Repositories\BussinessTypeRepository;
use src\Validation\validation;

class BussinessTypeService
{
    private BussinessTypeRepository $bussinessTypeRepository;
    private validation $validation;
    public function __construct()
    {
        $this->bussinessTypeRepository =new BussinessTypeRepository();
        $this->validation =new validation();
    }
    public function bussinessAdd(array $data): void
    {
        $this->validation->BussinessValidation($data);
        $this->bussinessTypeRepository->bussinessAdd($data);
    }
    public function bussinessGet():array{
        $result=$this->bussinessTypeRepository->bussinessGet();
        return $result;
    }
    // GET BY ID
    public function getById(int $id): array
    {
        if ($id <= 0) {
            throw new \Exception('Invalid business type ID');
        }

        $businessType = $this->bussinessTypeRepository->getById($id);

        if (!$businessType) {
            throw new \Exception('Business type not found');
        }

        return $businessType;
    }

    // UPDATE
    public function update(int $id, array $data): array
    {
        // Check record exists
        $this->getById($id);

        if (empty($data['bussines_type'])) {
            throw new \Exception('bussines_type is required');
        }

        // if (!isset($data['configuration'])) {
        //     throw new \Exception('configuration is required');
        // }

        return $this->bussinessTypeRepository->update($id, [
            'bussines_type' => trim($data['bussines_type']),
            'configuration' => $data['configuration']
        ]);
    }

    // DELETE
    public function delete(int $id): void
    {
        // Check record exists
        $this->getById($id);

        $deleted = $this->bussinessTypeRepository->delete($id);

        if (!$deleted) {
            throw new \Exception('Failed to delete business type');
        }
    }
}
