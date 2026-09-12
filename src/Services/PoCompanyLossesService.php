<?php

namespace src\Services;

use src\Repositories\PoCompanyLossesRepository;

class PoCompanyLossesService
{
    private PoCompanyLossesRepository $repository;

    public function __construct()
    {
        $this->repository = new PoCompanyLossesRepository();
    }


    // CREATE
    public function create(array $data): array
    {
        if (empty($data['purchase_order_item_id'])) {
            throw new \Exception(
                'purchase_order_item_id is required'
            );
        }

        if (
            !isset($data['loss_quantity']) ||
            $data['loss_quantity'] <= 0
        ) {
            throw new \Exception(
                'loss_quantity must be greater than 0'
            );
        }

        if (
            !isset($data['loss_amount']) ||
            $data['loss_amount'] < 0
        ) {
            throw new \Exception(
                'loss_amount cannot be negative'
            );
        }

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
            throw new \Exception(
                'Invalid loss ID'
            );
        }

        $loss = $this->repository->getById($id);

        if (!$loss) {
            throw new \Exception(
                'Loss record not found'
            );
        }

        return $loss;
    }


    // UPDATE
    public function update(int $id, array $data): array
    {
        $this->getById($id);

        if (empty($data['purchase_order_item_id'])) {
            throw new \Exception(
                'purchase_order_item_id is required'
            );
        }

        if (
            !isset($data['loss_quantity']) ||
            $data['loss_quantity'] <= 0
        ) {
            throw new \Exception(
                'loss_quantity must be greater than 0'
            );
        }

        if (
            !isset($data['loss_amount']) ||
            $data['loss_amount'] < 0
        ) {
            throw new \Exception(
                'loss_amount cannot be negative'
            );
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
                'Failed to delete loss record'
            );
        }
    }
}