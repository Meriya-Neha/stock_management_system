<?php
namespace src\Routes;

require_once __DIR__ . '/Router.php';
require_once __DIR__. '/../Controller/UserController.php';


use src\Controller\UserController;
use src\Controller\AuthController;
use src\Controller\BussinessTypeController;
use src\Controller\SupplierController;
use src\Controller\PurchaseOrderBillController;
use src\Controller\PoMainCategoryController;
use src\Controller\RoleController;
use src\Controller\UOMController;
use src\Controller\LocationController;
use src\Controller\PoOrderItemsController;
use src\Controller\ReturnReasoncontroller;
use src\Controller\PoPurchaseReturnController;

$router = new Router();

$userController = new UserController();
$bussinessController = new BussinessTypeController();
$authController =new AuthController();
$supplierController = new SupplierController();
$purchaseOrderBillController = new PurchaseOrderBillController();
$poMainCategoryController = new PoMainCategoryController();
$roleController = new RoleController();
$uomController=new UOMController();
$locationcontroller=new LocationController();
$poorderitemscontroller=new PoOrderItemsController();
$returnresoncontroller=new ReturnReasoncontroller();
$popurchasereturn=new PoPurchaseReturnController();


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

$router->group('/supplier',[
    'POST'=>[
        '/add'=>[$supplierController,'createSupplier']
    ],
    'GET'=>[
        '/get'=>[$supplierController,'getSupplier']
    ],
    // 'PUT'=>[
    //     '/update'=>[$supplierController,'updateSupplier']
    // ],
    'DELETE'=>[
        '/delete/{id}'=>[$supplierController,'deleteSupplier']
    ]
    
]);

$router->group('/purchase-order-bills',[
    'POST'=>[
        '/add'=>[$purchaseOrderBillController,'createPurchaseOrderBill'],
    ],
]);

$router->group('/po-main-category',[
    'POST'=>[
        '/add'=>[$poMainCategoryController,'createPoMainCategory'],
    ],
'GET'=>[
        '/list'=>[$poMainCategoryController,'getPoMainCategory'],
    ]
]);

$router->group("/role", [
    'POST' => [
        '/add' => [$roleController, 'createRole'],
    ],
    'GET' => [
        '/list' => [$roleController, 'getRoles'],
    ]
]);

$router->group("/UOM",[
    'POST'=>[
        '/add'=>[$uomController,'createUOM']
    ],
    'GET'=>[
        '/list'=>[$uomController,'getUOM']
    ]
]);

$router->group("/location",[
    'POST'=>[
        '/add'=>[$locationcontroller,'createLocation']
    ],
    'GET'=>[
        '/list'=>[$locationcontroller,'getLocation']
    ]
]);

$router->group("/purchase-order-item",[
    'POST'=>[
        '/add'=>[$poorderitemscontroller,'create']
    ]
]);

$router->group("/return-reason",[
    'POST'=>[
        '/add'=>[$returnresoncontroller,'create']
    ],
    'GET'=>[
        '/list'=>[$returnresoncontroller,'getAll']
    ]
]);

$router->group("/purchase-return-item",[
    'POST'=>[
        '/add'=>[$popurchasereturn,'createPurchaseReturn']
    ],
    'GET'=>[
        '/list'=>[$popurchasereturn,'getAll'],
        '/{id}'=>[$popurchasereturn,'getById']
    ]
]);


return $router;