<?php
namespace src\Services;
use src\Repositories\LocationRepository;
use src\validation\validation;


class LocationService{
    private LocationRepository $locationRepository;
    private validation $validation;

    public function __construct()
    {
        $this->locationRepository=new LocationRepository;
        $this->validation=new validation();
    }
    public function createLocation(array $data){
        $validation=$this->validation->LocationValidation($data);
        $result= $this->locationRepository->createLocation($data);
        return $result;

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