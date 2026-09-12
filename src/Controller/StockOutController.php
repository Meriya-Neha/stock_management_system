<?php

namespace src\Controller;

use src\Services\StockOutService;
use src\Utils\Response;

class StockOutController
{
    private StockOutService $stockOutService;

    public function __construct() {
        $this->stockOutService = new StockOutService();
    }


    // CREATE
    public function create(): void
    {
        try {

            $data = json_decode(
                file_get_contents("php://input"),
                true
            );

            if (!is_array($data)) {
                Response::badRequest(
                    'Invalid request data'
                );
            }

            $result = $this->stockOutService->create($data);

            Response::created(
                'Stock out created successfully.',
                $result
            );

        } catch (\Exception $e) {

            Response::badRequest(
                $e->getMessage()
            );
        }
    }


    // GET ALL
    public function getAll(): void
    {
        try {

            $result = $this->stockOutService->getAll();

            Response::success(
                'Stock out records fetched successfully.',
                $result
            );

        } catch (\Exception $e) {

            Response::internalError(
                'Failed to fetch stock out records.'
            );
        }
    }


    // GET BY ID
    public function getById(int $id): void
    {
        try {

            $result = $this->stockOutService->getById($id);

            Response::success(
                'Stock out record fetched successfully.',
                $result
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Stock out record not found') {
                Response::notFound(
                    $e->getMessage()
                );
            }

            Response::badRequest(
                $e->getMessage()
            );
        }
    }


    // UPDATE
    public function update(int $id): void
    {
        try {

            $data = json_decode(
                file_get_contents("php://input"),
                true
            );

            if (!is_array($data)) {
                Response::badRequest(
                    'Invalid request data'
                );
            }

            $result = $this->stockOutService->update(
                $id,
                $data
            );

            Response::success(
                'Stock out updated successfully.',
                $result
            );

        } catch (\Exception $e) {

            Response::badRequest(
                $e->getMessage()
            );
        }
    }


    // DELETE
    public function delete(int $id): void
    {
        try {

            $this->stockOutService->delete($id);

            Response::success(
                'Stock out deleted successfully.'
            );

        } catch (\Exception $e) {

            Response::badRequest(
                $e->getMessage()
            );
        }
    }
}