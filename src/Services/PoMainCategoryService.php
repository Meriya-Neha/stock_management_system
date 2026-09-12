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
    public function updatePoMainCategory(array $data)
    {
        return $this->poMainCategoryRepository->update($data);
    }
}
