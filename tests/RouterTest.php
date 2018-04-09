<?php

namespace DrMVC\Router\Tests;

use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;
use Zend\Diactoros\Uri;
use DrMVC\Router\Router;
use DrMVC\Router\Route;
use DrMVC\Router\Error;

class RouterTest extends TestCase
{
    public function test__construct()
    {
        try {
            $req = ServerRequestFactory::fromGlobals();
            $res = new Response();
            $obj = new Router($req, $res);
            $this->assertInternalType('object', $obj);
            $this->assertInstanceOf(Router::class, $obj);
        } catch (\Exception $e) {
            $this->assertContains('Must be initialized ', $e->getMessage());
        }
    }

    public function testGetRequest()
    {
        $req = ServerRequestFactory::fromGlobals();
        $res = new Response();
        $obj = new Router($req, $res);

        $request = $obj->getRequest();
        $this->assertInternalType('object', $request);
        $this->assertInstanceOf(ServerRequest::class, $request);
    }

    public function testGetResponse()
    {
        $req = ServerRequestFactory::fromGlobals();
        $res = new Response();
        $obj = new Router($req, $res);

        $response = $obj->getResponse();
        $this->assertInternalType('object', $response);
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testGetError()
    {
        $req = ServerRequestFactory::fromGlobals();
        $res = new Response();
        $obj = new Router($req, $res);

        $error = $obj->getError();
        $this->assertInternalType('object', $error);
        $this->assertInstanceOf(Error::class, $error);
    }

    public function testSetError()
    {
        $req = ServerRequestFactory::fromGlobals();
        $res = new Response();
        $obj = new Router($req, $res);
        $obj->setError(function() {
            return 'asd';
        });

        $error = $obj->getError();
        $this->assertInternalType('callable', $error);
        $this->assertEquals('asd', $error());
    }

    public function testGetRoute()
    {
        $req = ServerRequestFactory::fromGlobals();
        $res = new Response();
        $obj = new Router($req, $res);

        $route = $obj->getRoute();
        $this->assertInternalType('object', $route);
        $this->assertInstanceOf(Error::class, $route);
    }

    public function testSetRoute()
    {
        $req = ServerRequestFactory::fromGlobals();
        $res = new Response();
        $obj = new Router($req, $res);

        $route = new Route([''], 'test', function() {
            return 'zzz';
        });
        $obj->setRoute($route);
        $route = $obj->getRoute();
        $this->assertInternalType('object', $route);
        $this->assertInstanceOf(Route::class, $route);
    }

    public function testGetRoutes()
    {
        $req = ServerRequestFactory::fromGlobals();
        $res = new Response();
        $obj = new Router($req, $res);

        $route = new Route([''], 'test', function() {
            return 'zzz';
        });
        $obj->setRoute($route);
        $routes = $obj->getRoutes();
        $this->assertInternalType('array', $routes);
        $this->assertCount(1, $routes);
    }

    public function test__call()
    {
        $url = new Uri('https://example.com');
        $req = new ServerRequest([], [], $url);
        $res = new Response();
        $obj = new Router($req, $res);

        $callback = function() {
            return 'qqq';
        };
        $obj->get('', $callback);
        $route = $obj->getRoute();
        $cb = $route->getCallback();
        $this->assertInternalType('object', $route);
        $this->assertInstanceOf(Route::class, $route);
        $this->assertInternalType('callable', $cb);
        $this->assertEquals('qqq', $cb());
    }

    public function testMap()
    {
        $url = new Uri('https://example.com');
        $req = new ServerRequest([], [], $url);
        $res = new Response();
        $obj = new Router($req, $res);

        $callback = function() {
            return 'qqq';
        };
        $obj->map(['get', 'post'], '', $callback);
        $route = $obj->getRoute();
        $cb = $route->getCallback();
        $this->assertInternalType('object', $route);
        $this->assertInstanceOf(Route::class, $route);
        $this->assertInternalType('callable', $cb);
        $this->assertEquals('qqq', $cb());
    }

    public function testSet()
    {
        $url = new Uri('https://example.com/test');
        $req = new ServerRequest([], [], $url);
        $res = new Response();
        $obj = new Router($req, $res);

        $callback = function() {
            return 'zxczxc';
        };
        $obj->set(['get'], ['/test', $callback]);
        $route = $obj->getRoute();
        $cb = $route->getCallback();
        $this->assertInternalType('object', $route);
        $this->assertInstanceOf(Route::class, $route);
        $this->assertInternalType('callable', $cb);
        $this->assertEquals('zxczxc', $cb());
    }

    public function testAny()
    {
        $url = new Uri('https://example.com');
        $req = new ServerRequest([], [], $url);
        $res = new Response();
        $obj = new Router($req, $res);

        $callback = function() {
            return 'qqq';
        };
        $obj->any('', $callback);
        $route = $obj->getRoute();
        $cb = $route->getCallback();
        $this->assertInternalType('object', $route);
        $this->assertInstanceOf(Route::class, $route);
        $this->assertInternalType('callable', $cb);
        $this->assertEquals('qqq', $cb());
    }

    public function testError()
    {
        $url = new Uri('https://example.com');
        $req = new ServerRequest([], [], $url);
        $res = new Response();
        $obj = new Router($req, $res);

        $callback = function() {
            return 'zxc';
        };
        $obj->error($callback);
        $cb = $obj->getError();
        $this->assertInternalType('callable', $cb);
        $this->assertEquals('zxc', $cb());
    }
}
