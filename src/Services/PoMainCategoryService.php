<?php
namespace src\Services;
use src\Repositories\PoMainCategoryRepository;

class PoMainCategoryService
{
    private PoMainCategoryRepository $poMainCategoryRepository;

    public function __construct()
    {
        $this->poMainCategoryRepository = new PoMainCategoryRepository();
    }

    public function createPoMainCategory(array $data)
    {
        return $this->poMainCategoryRepository->create($data);
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
