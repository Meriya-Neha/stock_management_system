<?php

namespace src\Services;

use src\Repositories\StockOutRepository;

class StockOutService
{
    private StockOutRepository $stockOutRepository;

    public function __construct() {
        $this->stockOutRepository =new StockOutRepository();
    }


    // CREATE
    public function create(array $data): array
    {
        if (empty($data['purchase_order_id'])) {
            throw new \Exception(
                'purchase_order_id is required'
            );
        }

        if (empty($data['uom_id'])) {
            throw new \Exception(
                'uom_id is required'
            );
        }

        if (
            !isset($data['quantity']) ||
            $data['quantity'] <= 0
        ) {
            throw new \Exception(
                'quantity must be greater than 0'
            );
        }

        if (empty($data['stock_out_date'])) {
            throw new \Exception(
                'stock_out_date is required'
            );
        }

        return $this->stockOutRepository->create($data);
    }


    // GET ALL
    public function getAll(): array
    {
        return $this->stockOutRepository->getAll();
    }


    // GET BY ID
    public function getById(int $id): array
    {
        if ($id <= 0) {
            throw new \Exception(
                'Invalid stock out ID'
            );
        }

        $stockOut = $this->stockOutRepository->getById($id);

        if (!$stockOut) {
            throw new \Exception(
                'Stock out record not found'
            );
        }

        return $stockOut;
    }


    // UPDATE
    public function update(int $id, array $data): array
    {
        // Check record exists
        $this->getById($id);

        if (empty($data['purchase_order_id'])) {
            throw new \Exception(
                'purchase_order_id is required'
            );
        }

        if (empty($data['uom_id'])) {
            throw new \Exception(
                'uom_id is required'
            );
        }

        if (
            !isset($data['quantity']) ||
            $data['quantity'] <= 0
        ) {
            throw new \Exception(
                'quantity must be greater than 0'
            );
        }

        if (empty($data['stock_out_date'])) {
            throw new \Exception(
                'stock_out_date is required'
            );
        }

        return $this->stockOutRepository->update(
            $id,
            $data
        );
    }


    // DELETE
    public function delete(int $id): void
    {
        // Check record exists
        $this->getById($id);

        $deleted = $this->stockOutRepository->delete($id);

        if (!$deleted) {
            throw new \Exception(
                'Failed to delete stock out record'
            );
        }
    }
}