<?php
require_once __DIR__ . '/../vendor/autoload.php';

use DrMVC\Router\Route;
use DrMVC\Router\Error;

$route = new Route('get', '/<action>', function () {
    echo 'asd';
});
print_r($route);

$route = new Route('get', '/<zzz>', Error::class . ':test');
print_r($route);
