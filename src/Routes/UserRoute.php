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
use src\Controller\PoCompanyLossesController;
use src\Controller\StockOutController;

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
$pocompanylosses=new PoCompanyLossesController();
$stockout =new StockOutController();


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
    'GET'=>[
        '/get'=>[$bussinessController,'bussinessGet'],
        '/get/{id}'=>[$bussinessController,'getById']
    ],
    'PUT'=>[
        '/update/{id}'=>[$bussinessController,'update']
    ],
    'DELETE'=>[
        '/delete/{id}'=>[$bussinessController,'delete']
    ]
    
]);


$router->group('/supplier',[
    'POST'=>[
        '/add'=>[$supplierController,'createSupplier']
    ],
    'GET'=>[
        '/get'=>[$supplierController,'getSupplier'],
        '/get/{id}'=>[$supplierController,'getById']
    ],
    'PUT'=>[
        '/update/{id}'=>[$supplierController,'update']
    ],
    'DELETE'=>[
        '/delete/{id}'=>[$supplierController,'delete']
    ]
    
]);

$router->group('/purchase-order-bills',[
    'POST'=>[
        '/add'=>[$purchaseOrderBillController,'createPurchaseOrderBill'],
    ],
    'GET'=>[
        '/list'=>[$purchaseOrderBillController,'getAll'],
        '/get/{id}'=>[$purchaseOrderBillController,'getById']
    ],
    'PUT'=>[
        '/put/{id}'=>[$purchaseOrderBillController,'update']
    ],
    'DELETE'=>[
        '/delete/{id}'=>[$purchaseOrderBillController,'delete']
    ]
]);

$router->group('/po-main-category',[
    'POST'=>[
        '/add'=>[$poMainCategoryController,'createPoMainCategory'],
    ],
'GET'=>[
        '/list'=>[$poMainCategoryController,'getPoMainCategory'],
        '/get/{id}'=>[$poMainCategoryController,'getById']
    ],
    'PUT'=>[
        '/put/{id}'=>[$poMainCategoryController,'update']
    ],
    'DELETE'=>[
        '/delete/{id}'=>[$poMainCategoryController,'delete']
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
        '/list'=>[$uomController,'getUOM'],
        '/get/{id}'=>[$uomController,'getById']
    ],
    'PUT'=>[
        '/put/{id}'=>[$uomController,'update']
    ],
    'DELETE'=>[
        '/delete/{id}'=>[$uomController,'delete']
    ]
    
]);

$router->group("/location",[
    'POST'=>[
        '/add'=>[$locationcontroller,'createLocation']
    ],
    'GET'=>[
        '/list'=>[$locationcontroller,'getLocation'],
        '/get/{id}'=>[$locationcontroller,'getById']
    ],
    'PUT'=>[
        '/update/{id}'=>[$locationcontroller,'update']
    ],
    'DELETE'=>[
        '/delete/{id}'=>[$locationcontroller,'delete']
    ]
]);

$router->group("/purchase-order-item",[
    'POST'=>[
        '/add'=>[$poorderitemscontroller,'create']
    ],
    'GET'=>[
        '/list'=>[$poorderitemscontroller,'getAll'],
        '/get/{id}'=>[$poorderitemscontroller,'getById']
    ],
    'PUT'=>[
        '/put/{id}'=>[$poorderitemscontroller,'update']
    ],
    'DELETE'=>[
        '/delete/{id}'=>[$poorderitemscontroller,'delete']
    ]
]);

$router->group("/return-reason",[
    'POST'=>[
        '/add'=>[$returnresoncontroller,'create']
    ],
    'GET'=>[
        '/list'=>[$returnresoncontroller,'getAll'],
        '/get/{id}'=>[$returnresoncontroller,'getById']
    ],
    'PUT'=>[
        '/put/{id}'=>[$returnresoncontroller,'update']
    ],
    'DELETE'=>[
        '/delete/{id}'=>[$returnresoncontroller,'delete']
    ]
]);

$router->group("/purchase-return-item",[
    'POST'=>[
        '/add'=>[$popurchasereturn,'createPurchaseReturn']
    ],
    'GET'=>[
        '/list'=>[$popurchasereturn,'getAll'],
        '/{id}'=>[$popurchasereturn,'getById']
    ],
    'PUT'=>[
        '/put/{id}'=>[$popurchasereturn,'update']
    ],
    'DELETE'=>[
        '/delete/{id}'=>[$popurchasereturn,'delete']
    ]
]);

$router->group("/company-losses",[
    'POST'=>[
        '/add'=>[$pocompanylosses,'create']
    ],
    'GET'=>[
        '/list'=>[$pocompanylosses,'getAll'],
        '/get/{id}'=>[$pocompanylosses,'getById']
    ],
    'PUT'=>[
        '/put/{id}'=>[$pocompanylosses,'update']
    ],
    'DELETE'=>[
        '/delete/{id}'=>[$pocompanylosses,'delete']
    ]
]);

$router->group("/stock-out", [

    'POST' => [
        '/add' => [$stockout, 'create']
    ],

    'GET' => [
        '/list' => [$stockout, 'getAll'],
        '/get/{id}' => [$stockout, 'getById']
    ],

    'PUT' => [
        '/update/{id}' => [$stockout, 'update']
    ],

    'DELETE' => [
        '/delete/{id}' => [$stockout, 'delete']
    ]

]);

return $router;