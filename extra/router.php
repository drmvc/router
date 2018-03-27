<?php
require_once __DIR__ . '/../vendor/autoload.php';

use DrMVC\Route;
use DrMVC\Router;
use DrMVC\Url;

$url = new Url('https://example.com/action/zzz');
$router = new Router($url);

$router
    ->get('/action/zzz',
        function () {
            echo "action\n";
        }
    )
    ->get('/asd',
        function () {
            echo "asd\n";
        }
    );

$router->parse()->execute();
