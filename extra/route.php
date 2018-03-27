<?php
require_once __DIR__ . '/../vendor/autoload.php';

use DrMVC\Route;

$route = new Route('get', '/<action>', function () {
    echo 'asd';
});
print_r($route);

$route = new Route('get', '/<action>', \DrMVC\Route::class . ':zzz');
print_r($route);