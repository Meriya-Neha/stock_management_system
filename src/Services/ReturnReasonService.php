<?php
namespace src\Services;
use src\Repositories\ReturnReasonRepository;
use src\validation\validation;

class ReturnReasonService{
    private ReturnReasonRepository $repository;
    private validation $validation;
    public function __construct()
    {
        $this->repository = new ReturnReasonRepository();
        $this->validation= new validation();
    }
    public function create(array $data){
        try{
            // $validation=$this->validation->Re
            $result=$this->repository->create($data);
            return $result;
        }
        catch(\Throwable $e){
            die($e);
        }
    }
     public function getAll(){
        return $this->repository->getAll();
    }

     // GET BY ID
    public function getById(int $id): array
    {
        if ($id <= 0) {
            throw new \Exception('Invalid reason ID');
        }

        $reason = $this->repository->getById($id);

        if (!$reason) {
            throw new \Exception('Return reason not found');
        }

        return $reason;
    }

    // UPDATE
    public function update(int $id, array $data): array
    {
        $this->getById($id);

        if (empty($data['reason'])) {
            throw new \Exception('reason is required');
        }

        return $this->repository->update($id, [
            'reason' => trim($data['reason'])
        ]);
    }

    // DELETE
    public function delete(int $id): void
    {
        $this->getById($id);

        $deleted = $this->repository->delete($id);

        if (!$deleted) {
            throw new \Exception('Failed to delete return reason');
        }
    }
}

?>