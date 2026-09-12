<?php
namespace src\Services;
use src\Repositories\ReturnReasonRepository;

class ReturnReasonService{
    private ReturnReasonRepository $repository;
    public function __construct()
    {
        $this->repository = new ReturnReasonRepository();
    }
    public function create(array $data){
        try{
            $result=$this->repository->create($data);
            return $result;
        }
        catch(\Throwable $e){
            die($e);
        }
    }

    public function getAll(){
        try{
            $result=$this->repository->getAll();
            return $result;
        }
        catch(\Throwable $e){
            die($e);
        }
    }
}

?>