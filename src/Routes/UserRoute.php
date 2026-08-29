<?php
namespace src\Routes;

require_once __DIR__ . '/Router.php';
require_once __DIR__. '/../Controller/UserController.php';


use src\Controller\UserController;
use src\Controller\AuthController;
use src\Controller\BussinessTypeController;


$router = new Router();

$userController = new UserController();
$bussinessController = new BussinessTypeController();
$authController =new AuthController();
// $bussinessController = new BussinessTypeController();



$router->get('/', function () {
    echo json_encode([
        'status' => 'okk'
    ]);
});



$router->get('/', function () {
    echo json_encode([
        'status' => 'okk'
    ]);
});

$router->group('/user', [
    'POST' => [
        '/add' => [$userController, 'createUser'],
    ],

    'GET' => [
        '/list' => [$userController, 'getUsers'],
        '/single' => [$userController, 'getUser'],
    ]

]);

$router->group('/auth',[
    'POST'=>[
        '/login'=>[$authController,'authLogin']
    ]
]);

$router->group('/bussiness_type',[
    'POST'=>[
        '/add'=>[$bussinessController,'bussinessAdd']
    ],
    
]);

$router->group('/bussiness_type',[
    'GET'=>[
        '/get'=>[$bussinessController,'bussinessGet']
    ]
]);

return $router;