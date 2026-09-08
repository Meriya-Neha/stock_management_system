<?php
namespace src\Routes;

use src\Controller\PurchaseOrderBillController;

$router= new Router();

$purchaseOrderBillController= new PurchaseOrderBillController();

$router->group('/purchase-order-bills',[
    'POST'=>[
        '/add'=>[$purchaseOrderBillController,'createPurchaseOrderBill'],
    ],
])

?>