<?php
require_once __DIR__ . '/../vendor/autoload.php';

use DrMVC\Router\Route;

$route = new Route(['get'], '/<action>', function () {
    echo 'asd';
});
print_r($route);

$route = new Route(['put'], '/<zzz>', \DrMVC\Router\Error::class . ':test');
print_r($route);
