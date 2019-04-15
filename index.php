<?php
declare(strict_types=1);

require 'vendor/autoload.php';
header('Content-type:application/json;charset=utf-8');

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/devices', 'App\AbstractDeviceDetector:devices:');
    $r->addRoute('GET', '/detect', 'App\Detector:detect:hasDependency');
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$container = new DI\Container();

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo 'not found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo 'not allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        list($controller, $action, $dependency) = explode(":", $routeInfo[1], 3);
        echo json_encode($container->get($controller)->$action());
        break;
}
