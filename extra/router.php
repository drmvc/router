<?php
require_once __DIR__ . '/../vendor/autoload.php';

use DrMVC\Router;
use DrMVC\Router\Url;

$request = new Url('https://example.com/aaa/bbb/vv');
//$request = new Url('https://example.com/action/zzz');
//$request = new Url('https://example.com/bbb/zzz/ccc');

$router = new Router($request);

// Set routes
$router
    ->get('/aaa/<action>/<action2>', DrMVC\Router\Controllers\Index::class)
    ->get('/bbb/zzz/ccc', DrMVC\Router\Controllers\Index::class)
    ->get('/action/zzz',
        function () {
            echo "action\n";
        }
    );

// Set custom error class or closure
$router
    ->error(DrMVC\Router\Controllers\Error::class);

print_r($router);

$test = $router->parse()->execute();

print_r($test);
