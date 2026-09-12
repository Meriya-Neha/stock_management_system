<?php

namespace src\Controller;

use src\Services\PoCompanyLossesService;
use src\Utils\Response;

class PoCompanyLossesController
{
    private PoCompanyLossesService $service;

    public function __construct()
    {
        $this->service =new  PoCompanyLossesService();
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

            $result = $this->service->create($data);

            Response::created(
                'Loss record created successfully.',
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

            $result = $this->service->getAll();

            Response::success(
                'Loss records fetched successfully.',
                $result
            );

        } catch (\Exception $e) {

            Response::internalError(
                'Failed to fetch loss records.'
            );
        }
    }


    // GET BY ID
    public function getById(int $id): void
    {
        try {

            $result = $this->service->getById($id);

            Response::success(
                'Loss record fetched successfully.',
                $result
            );

        } catch (\Exception $e) {

            if ($e->getMessage() === 'Loss record not found') {
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

            $result = $this->service->update(
                $id,
                $data
            );

            Response::success(
                'Loss record updated successfully.',
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

            $this->service->delete($id);

            Response::success(
                'Loss record deleted successfully.'
            );

        } catch (\Exception $e) {

            Response::badRequest(
                $e->getMessage()
            );
        }
    }
}