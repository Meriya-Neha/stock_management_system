<?php
namespace src\Routes;
use src\controller\PoMainCategoryController;

$router= new Router();
$poMainCategoryController= new PoMainCategoryController();

$router->group('/po-main-category',[
    'POST'=>[
        '/add'=>[$poMainCategoryController,'createPoMainCategory'],
    ],
]);

?>