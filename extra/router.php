<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response as ServerResponse;
use Zend\Diactoros\Uri;
use DrMVC\Router;

// Generate url
$url = new Uri('https://example.com/aaa/zzz/bbb');
//$url = new Uri('https://example.com/aaa/zzz');

// PSR Request and Response
//$request = ServerRequest::fromGlobals();
$request = new ServerRequest([], [], $url);
$response = new ServerResponse();

// Router object
$router = new Router($request, $response);

// Set routes
$router
    ->get('/aaa/<action>/<action2>', DrMVC\Router\Controllers\Index::class)
    ->get('/bbb/zzz/ccc', DrMVC\Router\Controllers\Index::class)
    ->get('/action/zzz',
        function () {
            echo "action\n";
        }
    );

$parsed = $router->getRoute();
print_r($parsed);
