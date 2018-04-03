[![Latest Stable Version](https://poser.pugx.org/drmvc/router/v/stable)](https://packagist.org/packages/drmvc/router)
[![Build Status](https://travis-ci.org/drmvc/router.svg?branch=master)](https://travis-ci.org/drmvc/router)
[![Total Downloads](https://poser.pugx.org/drmvc/router/downloads)](https://packagist.org/packages/drmvc/router)
[![License](https://poser.pugx.org/drmvc/router/license)](https://packagist.org/packages/drmvc/router)
[![PHP 7 ready](https://php7ready.timesplinter.ch/drmvc/router/master/badge.svg)](https://travis-ci.org/drmvc/router)
[![Code Climate](https://codeclimate.com/github/drmvc/router/badges/gpa.svg)](https://codeclimate.com/github/drmvc/router)
[![Scrutinizer CQ](https://scrutinizer-ci.com/g/drmvc/router/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/drmvc/router/)

# DrMVC\Router

Simple router based on PSR-7 HTTP Message recommendation.

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
    ->get('/bbb/zzz/ccc', 'App\Controllers\Index:default')
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
