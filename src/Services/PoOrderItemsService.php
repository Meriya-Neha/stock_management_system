<?php

namespace src\Services;

use App\Repositories\PurchaseOrderBillProductRepository;
use src\Repositories\PoOrderItemRepository;

class PoOrderItemsService
{
    private PoOrderItemRepository $repository;

    public function __construct()
    {
        $this->repository = new PoOrderItemRepository();
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
}