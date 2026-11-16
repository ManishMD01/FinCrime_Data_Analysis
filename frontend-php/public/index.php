<?php
declare(strict_types=1);

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    }
});

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($request_uri, '/');

$routes = [
    '' => ['controller' => 'DashboardController', 'method' => 'index'],
    'dashboard' => ['controller' => 'DashboardController', 'method' => 'index'],
    'transactions' => ['controller' => 'TransactionsController', 'method' => 'index'],
    'fraud-analytics' => ['controller' => 'FraudAnalyticsController', 'method' => 'index'],
    'investigations' => ['controller' => 'InvestigationsController', 'method' => 'index'],
    'network-analysis' => ['controller' => 'NetworkAnalysisController', 'method' => 'index'],
];

$route = $routes[$path] ?? $routes['dashboard'];

$controllerClass = 'App\\Controllers\\' . $route['controller'];
$method = $route['method'];

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    echo $controller->$method();
} else {
    http_response_code(404);
    echo '<h1>404 - Page Not Found</h1>';
}