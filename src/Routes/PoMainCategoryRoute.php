<?php
namespace src\Routes;
use src\controller\PoMainCategoryController;

class PoMainCategoryRoute
{
    private PoMainCategoryController $poMainCategoryController;

    public function __construct()
    {
        $this->poMainCategoryController = new PoMainCategoryController();
    }
}
