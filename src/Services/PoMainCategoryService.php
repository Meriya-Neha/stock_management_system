<?php
namespace src\Services;
use src\Repositories\PoMainCategoryRepository;
use src\validation\validation;

class PoMainCategoryService
{
    private PoMainCategoryRepository $poMainCategoryRepository;
    private validation $validation;

    public function __construct()
    {
        $this->poMainCategoryRepository = new PoMainCategoryRepository();
        $this->validation= new validation();
    }

    public function createPoMainCategory(array $data)
    {
        $validation=$this->validation->Main_category($data);
        $result= $this->poMainCategoryRepository->create($data);
        return $result;
    }
    public function getPoMainCategory()
    {
        return $this->poMainCategoryRepository->getAll();
    }
    
      // GET BY ID
    public function getById(int $id): array
    {
        if ($id <= 0) {
            throw new \Exception('Invalid category ID');
        }

        $category = $this->poMainCategoryRepository->getById($id);

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

        return $this->poMainCategoryRepository->update($id, $name);
    }

    // DELETE
    public function delete(int $id): void
    {
        $this->getById($id);

        $deleted = $this->poMainCategoryRepository->delete($id);

        if (!$deleted) {
            throw new \Exception('Failed to delete category');
        }
    }
}
