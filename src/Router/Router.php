<?php

namespace DrMVC\Router;

use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;
use DrMVC\Exceptions\ArrayException;

/**
 * Class Router
 * @package DrMVC
 * @method Router get(string $pattern, callable $callable): Interfaces\Router
 * @method Router post(string $pattern, callable $callable): Interfaces\Router
 * @method Router put(string $pattern, callable $callable): Interfaces\Router
 * @method Router delete(string $pattern, callable $callable): Interfaces\Router
 * @method Router option(string $pattern, callable $callable): Interfaces\Router
 */
class Router implements Interfaces\Router
{
    /**
     * Array with all available routes
     * @var array
     */
    private $_routes = [];

    /**
     * Class with error inside
     * @var callable|string
     */
    private $_error = 'DrMVC\Router\Error';

    /**
     * @var \Zend\Diactoros\ServerRequest
     */
    private $_request;

    /**
     * @var \Zend\Diactoros\Response
     */
    private $_response;

    /**
     * Router constructor.
     *
     * @param   ServerRequest $request
     * @param   Response $response
     */
    public function __construct(ServerRequest $request, Response $response)
    {
        $this
            ->setRequest($request)
            ->setResponse($response);
    }

    /**
     * @param   mixed $request
     * @return  Interfaces\Router
     */
    public function setRequest($request): Interfaces\Router
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * @return ServerRequest
     */
    public function getRequest(): ServerRequest
    {
        return $this->_request;
    }

    /**
     * @param   mixed $response
     * @return  Interfaces\Router
     */
    public function setResponse($response): Interfaces\Router
    {
        $this->_response = $response;
        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->_response;
    }

    /**
     * Overwrite default error class
     *
     * @param   callable|string $error
     * @return  Interfaces\Router
     */
    public function setError($error): Interfaces\Router
    {
        $this->_error = $error;
        return $this;
    }

    /**
     * @return callable|string
     */
    public function getError()
    {
        $error = $this->_error;
        return new $error();
    }

    /**
     * Parse URI by Regexp from routes and return single route
     *
     * @return  Interfaces\Route
     */
    public function getRoute()
    {
        // Find route by regexp and URI
        $matches = array_map(
            // Foreach emulation
            function($regexp, $route) {
                $uri = $this->getRequest()->getUri()->getPath();
                $match = preg_match_all($regexp, $uri, $matches);

                // If something found
                if ($match) {
                    // Set array of variables
                    $route->setVariables($matches);
                    return $route;
                } else {
                    return null;
                }
            },
            // Array with keys
            $this->getRoutes(true),
            // Array with values
            $this->getRoutes()
        );

        // Cleanup the array of matches, then reindex array
        $matches = array_values(array_filter($matches));

        // If we have some classes in result of regexp
        if (!empty($matches)) {
            // Take first from matches
            $result = $matches[0]; // Here the Route() object
        } else {
            // Create new object with error inside
            $result = $this->getError();
        }

        $result->setRequest($this->getRequest());
        $result->setResponse($this->getResponse());

        return $result;
    }

    /**
     * Abstraction of setter
     *
     * @param   string $method
     * @param   array $args
     * @return  Interfaces\Router
     */
    private function set(string $method, array $args): Interfaces\Router
    {
        $pattern = $args[0];
        $callable = $args[1];
        $route = new Route($method, $pattern, $callable, $this->getRequest(), $this->getResponse());
        $this->setRoute($route);
        return $this;
    }

    /**
     * Some kind of magic ;) details in header of this class, in @methods
     *
     * @param   string $method
     * @param   $args
     * @return  Interfaces\Router
     */
    public function __call(string $method, $args)
    {
        if (in_array($method, Router::METHODS)) {
            $this->set($method, $args);
        }
        return $this;
    }

    /**
     * Add route into the array of routes
     *
     * @param   Interfaces\Route $route
     */
    private function setRoute(Interfaces\Route $route)
    {
        $regexp = $route->getRegexp();
        $this->_routes[$regexp] = $route;
    }

    /**
     * Get all available routes
     *
     * @param   bool $keys - Return only keys
     * @return  array
     */
    public function getRoutes(bool $keys = false): array
    {
        return $keys
            ? array_keys($this->_routes)
            : $this->_routes;
    }

    /**
     * Callable must be only selected methods
     *
     * @param   array $methods
     * @param   string $pattern
     * @param   callable $callable
     * @return  Interfaces\Router
     */
    public function map(array $methods, string $pattern, callable $callable): Interfaces\Router
    {
        array_map(
            function($method) use ($pattern, $callable) {
                $method = strtolower($method);

                try {
                    ArrayException::inArray($method, Router::METHODS);
                } catch (ArrayException $e) {
                }

                $this->$method($pattern, $callable);
            },
            $methods
        );
        return $this;
    }

    /**
     * Any method should be callable
     *
     * @param   string $pattern
     * @param   callable $callable
     * @return  Interfaces\Router
     */
    public function any(string $pattern, callable $callable): Interfaces\Router
    {
        return $this->map(Router::METHODS, $pattern, $callable);
    }
}