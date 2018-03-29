# DrMVC\Router

Simple router based on PSR-7 HTTP Message implementation by Zend.

    composer require drmvc/router

## How to use

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Zend\Diactoros\ServerRequestFactory as ServerRequest;
use Zend\Diactoros\Response as ServerResponse;
use DrMVC\Router;

// PSR Request and Response
$request = ServerRequest::fromGlobals();
$response = new ServerResponse();

// Router object
$router = new Router($request, $response);

// Set routes
$router
    ->get('/aaa/<action>/<action2>', DrMVC\Controllers\Index::class)
    ->get('/bbb/zzz/ccc', DrMVC\Controllers\Index::class . ':default')
    ->get(
        '/action/zzz',
        function() {
            echo "action\n";
        }
    );

$route = $router->getRoute();
print_r($route);
```

## About PHP Unit Tests

First need to install all dev dependencies via `composer update`, then
you can run tests by hands from source directory via `./vendor/bin/phpunit` command.

# Links

* [DrMVC Framework](https://drmvc.com)
