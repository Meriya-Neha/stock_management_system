<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';

$router = require __DIR__ . '/../src/Routes/UserRoute.php';
// $router = require __DIR__ . '/../src/Routes/PoMainCategoryRoute.php';
// $router = require __DIR__ . '/../src/Routes/PurchaseOrderBillRoute.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Strip subfolder prefix if running inside a subfolder (e.g., /your-project/auth/login -> /auth/login)
$basePath = '/your-project'; // Change to match your folder name in htdocs, or use '' if root
if (!empty($basePath) && strpos($path, $basePath) === 0) {
    $path = substr($path, strlen($basePath));
}

if (!$router->dispatch($method, $path)) {
    http_response_code(404);
    echo json_encode([
        'status' => false,
        'message' => 'Route not found'
    ]);
}
?>