<?php
require_once __DIR__ . '/../vendor/autoload.php';

use DrMVC\Router\Route;
use DrMVC\Router\Controllers\Index;

$route = new Route('get', '/<action>', function () {
    echo 'asd';
});
print_r($route);

$route = new Route('get', '/<zzz>', Index::class . ':test');
print_r($route);