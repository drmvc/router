<?php

namespace Router;

use PHPUnit\Framework\TestCase;
use DrMVC\Router\Route;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;

class RouteTest extends TestCase
{

    public function test__construct()
    {
        try {
            $obj = new Route('', '', '');
            $this->assertInternalType('object', $obj);
        } catch (\Exception $e) {
            $this->assertContains('Must be initialized ', $e->getMessage());
        }
    }

    public function testGetMethod()
    {
        $obj = new Route('get', '', '');
        $method = $obj->getMethod();

        $this->assertInternalType('string', $method);
        $this->assertEquals('get', $method);
    }

    public function testSetMethod()
    {
        $obj = new Route('', '', '');
        $method = $obj->getMethod();
        $this->assertEmpty($method);

        $obj->setMethod('get');
        $method2 = $obj->getMethod();
        $this->assertInternalType('string', $method2);
        $this->assertEquals('get', $method2);
    }

    public function testGetVariables()
    {
        $obj = new Route('', '', '');
        $variables = $obj->getVariables();

        $this->assertInternalType('array', $variables);
        $this->assertEmpty($variables);
    }

    public function testSetVariables()
    {
        $obj = new Route('', '', '');
        $obj->setVariables(['key' => 'value']);
        $variables = $obj->getVariables();

        $this->assertInternalType('array', $variables);
        $this->assertCount(1, $variables);
        $this->assertEquals($variables['key'], 'value');
    }

    public function testGetRequest()
    {
        $server_request = ServerRequestFactory::fromGlobals();
        $obj = new Route('', '', '', $server_request);
        $request = $obj->getRequest();

        $this->assertInternalType('object', $request);
        $this->assertInstanceOf(ServerRequest::class, $request);
    }

    public function testSetRequest()
    {
        $obj = new Route('', '', '');
        $request = $obj->getRequest();

        $this->assertInternalType('null', $request);

        $server_request = ServerRequestFactory::fromGlobals();
        $obj->setRequest($server_request);
        $request2 = $obj->getRequest();

        $this->assertInstanceOf(ServerRequest::class, $request2);
    }

    public function testSetResponse()
    {
        $server_response = new Response();
        $obj = new Route('', '', '', null, $server_response);
        $response = $obj->getResponse();

        $this->assertInternalType('object', $response);
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testGetResponse()
    {
        $obj = new Route('', '', '');
        $response = $obj->getResponse();

        $this->assertInternalType('null', $response);

        $server_response = new Response();
        $obj->setResponse($server_response);
        $response2 = $obj->getResponse();

        $this->assertInstanceOf(Response::class, $response2);
    }

    public function testGetCallback()
    {
        $callable = function() {
            return 'asd';
        };

        $obj = new Route('', '', $callable);
        $callback = $obj->getCallback();
        $this->assertInternalType('callable', $callback);

        $test = $callback();
        $this->assertEquals('asd', $test);
    }

    public function testSetCallback()
    {
        $callable = function() {
            return 'asd';
        };

        $obj = new Route('', '', '');
        $callback = $obj->getCallback();
        $this->assertEmpty($callback);

        $obj->setCallback($callable);
        $callback2 = $obj->getCallback();
        $this->assertInternalType('callable', $callback2);

        $test = $callback2();
        $this->assertEquals('asd', $test);
    }

    public function testGetRegexp()
    {
        $obj = new Route('', '/test/path', '');
        $regexp = $obj->getRegexp();
        $this->assertInternalType('string', $regexp);
        $this->assertEquals('#^/test/path$#u', $regexp);
    }

    public function testSetRegexp()
    {
        $obj = new Route('', '', '');
        $regexp = $obj->getRegexp();
        $this->assertEquals('#^$#u', $regexp);

        $obj->setRegexp('/test/path');
        $regexp2 = $obj->getRegexp();
        $this->assertInternalType('string', $regexp2);
    }

    public function testSetRoute()
    {
        $callable = function() {
            return 'asd';
        };

        $server_request = ServerRequestFactory::fromGlobals();
        $server_response = new Response();

        $obj = new Route('get', '/text', $callable, $server_request, $server_response);
        $method = $obj->getMethod();
        $regexp = $obj->getRegexp();
        $callback = $obj->getCallback();
        $request = $obj->getRequest();
        $response = $obj->getResponse();

        $this->assertEquals('get', $method);
        $this->assertEquals('#^/text$#u', $regexp);
        $this->assertInternalType('callable', $callback);
        $this->assertInstanceOf(ServerRequest::class, $request);
        $this->assertInstanceOf(Response::class, $response);
    }
}
