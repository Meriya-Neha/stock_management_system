<?php

namespace src\Services;

use App\Repositories\PurchaseOrderBillProductRepository;
use src\Repositories\PoOrderItemRepository;
use src\validation\validation;

class PoOrderItemsService
{
    private PoOrderItemRepository $repository;
    private validation $validation;

    public function __construct()
    {
        $this->repository = new PoOrderItemRepository();
        $this->validation=new validation();

    }

    public function create(array $data): array
    {
        // Required fields validation
        $requiredFields = [
            'purchase_order_bill_id',
            'product_name',
            'product_main_category_id',
            'item_location_id',
            'uom_id',
            'quantity',
            'purchase_price',
            'purchase_date'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                throw new \Exception("$field is required");
            }
        }

        // Calculate total price
        $data['total_price'] =
            (float)$data['quantity'] * (float)$data['purchase_price'];

        return $this->repository->create($data);
    }
     // GET ALL
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    // GET BY ID
    public function getById(int $id): array
    {
        if ($id <= 0) {
            throw new \Exception('Invalid purchase order item ID');
        }

        $item = $this->repository->getById($id);

        if (!$item) {
            throw new \Exception('Purchase order item not found');
        }

        return $item;
    }

    // UPDATE
    public function update(int $id, array $data): array
    {
        $this->getById($id);

        if (empty($data['purchase_order_bill_id'])) {
            throw new \Exception('purchase_order_bill_id is required');
        }

        if (empty($data['product_name'])) {
            throw new \Exception('product_name is required');
        }

        if (empty($data['product_main_category_id'])) {
            throw new \Exception('product_main_category_id is required');
        }

        if (empty($data['item_location_id'])) {
            throw new \Exception('item_location_id is required');
        }

        if (empty($data['uom_id'])) {
            throw new \Exception('uom_id is required');
        }

        if (!isset($data['quantity']) || $data['quantity'] <= 0) {
            throw new \Exception('quantity must be greater than 0');
        }

        if (!isset($data['purchase_price']) || $data['purchase_price'] < 0) {
            throw new \Exception('purchase_price is required');
        }

        if (!isset($data['total_price']) || $data['total_price'] < 0) {
            throw new \Exception('total_price is required');
        }

        if (empty($data['purchase_date'])) {
            throw new \Exception('purchase_date is required');
        }

        return $this->repository->update($id, $data);
    }

    // DELETE
    public function delete(int $id): void
    {
        $this->getById($id);

        $deleted = $this->repository->delete($id);

        if (!$deleted) {
            throw new \Exception(
                'Failed to delete purchase order item'
            );
        }
    }
}