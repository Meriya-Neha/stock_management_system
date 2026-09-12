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
        return $this->uomRepository->create($data);
    }

    public function getUOM()
    {
        return $this->uomRepository->getUom();
    }
}

?>