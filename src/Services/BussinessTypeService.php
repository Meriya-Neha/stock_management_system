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
    public function bussinessAdd($data)
    {
        $this->validation->BussinessValidation($data);
        $this->bussinessTypeRepository->bussinessAdd($data);
    }
    public function bussinessGet():array{
        $result=$this->bussinessTypeRepository->bussinessGet();
        return $result;
    }
}
