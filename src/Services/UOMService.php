<?php
namespace src\Services;
use src\Repositories\UOMRepository;


class UOMService
{
    private UOMRepository $uomRepository;

    public function __construct()
    {
        $this->uomRepository = new UOMRepository();
    }
    public function createUOM(array $data)
    {
        $result= $this->uomRepository->create($data);
        return $result;
    }

    public function getUOM()
    {
        return $this->uomRepository->getUom();
    }

     // GET BY ID
    public function getById(int $id): array
    {
        if ($id <= 0) {
            throw new \Exception('Invalid UOM ID');
        }

        $uom = $this->uomRepository->getById($id);

        if (!$uom) {
            throw new \Exception('UOM not found');
        }

        return $uom;
    }

    // UPDATE
    public function update(int $id, array $data): array
    {
        $this->getById($id);

        if (empty($data['unit_of_measurement'])) {
            throw new \Exception('unit_of_measurement is required');
        }

        return $this->uomRepository->update($id, [
            'unit_of_measurement' => trim($data['unit_of_measurement'])
        ]);
    }

    // DELETE
    public function delete(int $id): void
    {
        $this->getById($id);

        $deleted = $this->uomRepository->delete($id);

        if (!$deleted) {
            throw new \Exception('Failed to delete UOM');
        }
    }
}

?>