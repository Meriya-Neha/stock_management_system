<?php
namespace src\Services;
use src\Repositories\PoPurchaseReturnRepository;

class PoPurchaseReturnService{
    private PoPurchaseReturnRepository $repository;

    public function __construct()
    {
        $this->repository=new PoPurchaseReturnRepository();
    }
    public function createPurchaseReturn(array $data)
{
    if (empty($data['purchase_order_id'])) {
        throw new \Exception("Purchase order is required.");
    }

    if (empty($data['quantity']) || $data['quantity'] <= 0) {
        throw new \Exception("Quantity must be greater than 0.");
    }

    if (empty($data['purchase_price']) || $data['purchase_price'] <= 0) {
        throw new \Exception("Purchase price must be greater than 0.");
    }

    if (empty($data['return_reason_id'])) {
        throw new \Exception("Return reason is required.");
    }

    if (empty($data['return_amount']) || $data['return_amount'] <= 0) {
        throw new \Exception("Return amount must be greater than 0.");
    }

    return $this->repository
                ->createPurchaseReturn($data);
}

public function getAll(): array
{
    $returns = $this->repository->getAll();

    return $returns;
}

public function getById(int $id): array
{
    $return = $this->repository
                   ->getById($id);

    if (!$return) {
        throw new \Exception('Purchase return not found.');
    }

    return $return;
}
}
?>