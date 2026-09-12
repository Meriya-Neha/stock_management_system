<?php
namespace src\Services;
use src\Repositories\LocationRepository;


class LocationService{
    private LocationRepository $locationRepository;

    public function __construct()
    {
        $this->locationRepository=new LocationRepository;
    }
    public function createLocation(array $data){
        return $this->locationRepository->createLocation($data);

    }

    public function getLocation(){
        return $this->locationRepository->getLocation();
    }
      // GET BY ID
    public function getById(int $id): array
    {
        if ($id <= 0) {
            throw new \Exception('Invalid category ID');
        }

        $category = $this->locationRepository->getById($id);

        if (!$category) {
            throw new \Exception('Category not found');
        }

        return $category;
    }

    // UPDATE
    public function update(int $id, array $data): array
    {
        $this->getById($id);

        if (empty($data['name'])) {
            throw new \Exception('name is required');
        }

        $name = trim($data['name']);

        return $this->locationRepository->update($id, $name);
    }

    // DELETE
    public function delete(int $id): void
    {
        $this->getById($id);

        $deleted = $this->locationRepository->delete($id);

        if (!$deleted) {
            throw new \Exception('Failed to delete category');
        }
    }
}
?>