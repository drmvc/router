<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response as ServerResponse;
use Zend\Diactoros\Uri;
use DrMVC\Router;

// Generate url
//$url = new Uri('https://example.com');
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
    ->get('', 'App\Controllers\Index:default')
    ->get('/aaa/<action>/<action2>', DrMVC\Router\Error::class)
    ->post('/bbb/zzz/ccc', 'App\Controllers\Index:default')
    ->put(
        '/action/zzz',
        function() {
            echo "action\n";
        }
    );

print_r($router);

$parsed = $router->getRoute();
print_r($parsed);
