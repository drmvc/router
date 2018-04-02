<?php

namespace DrMVC\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Router
 * @package DrMVC\Router
 * @method Router get(string $pattern, callable $callable): Router
 * @method Router post(string $pattern, callable $callable): Router
 * @method Router put(string $pattern, callable $callable): Router
 * @method Router delete(string $pattern, callable $callable): Router
 * @method Router option(string $pattern, callable $callable): Router
 * @since 3.0.0
 */
class Router implements RouterInterface
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
    private $_error = Error::class;

    /**
     * @var ServerRequestInterface
     */
    private $_request;

    /**
     * @var ResponseInterface
     */
    private $_response;

    /**
     * Router constructor.
     *
     * @param   ServerRequestInterface $request
     * @param   ResponseInterface $response
     */
    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this
            ->setRequest($request)
            ->setResponse($response);
    }

    /**
     * Some kind of magic ;) details in header of this class, in 'methods'
     *
     * @param   string $method
     * @param   array $args
     * @return  RouterInterface
     */
    public function __call(string $method, array $args): RouterInterface
    {
        if (\in_array($method, self::METHODS, false)) {
            $this->set([$method], $args);
        }
        return $this;
    }

    /**
     * Abstraction of setter
     *
     * @param   array $methods
     * @param   array $args
     * @return  RouterInterface
     */
    private function set(array $methods, array $args): RouterInterface
    {
        list($pattern, $callable) = $args;
        $route = new Route($methods, $pattern, $callable, $this->getRequest(), $this->getResponse());
        $this->setRoute($route);
        return $this;
    }

    /**
     * Callable must be only selected methods
     *
     * @param   array $methods
     * @param   string $pattern
     * @param   callable|string $callable
     * @return  RouterInterface
     */
    public function map(array $methods, string $pattern, $callable): RouterInterface
    {
        array_map(
            function($method) {
                $method = strtolower($method);

                try {
                    if (!\in_array($method, self::METHODS, false)) {
                        throw new Exception("Value \"$method\" is not in array");
                    }
                } catch (Exception $e) {
                    // Catch empty because __construct overloaded
                }
            },
            $methods
        );

        $this->set($methods, [$pattern, $callable]);

        return $this;
    }

    /**
     * Any method should be callable
     *
     * @param   string $pattern
     * @param   callable|string $callable
     * @return  RouterInterface
     */
    public function any(string $pattern, $callable): RouterInterface
    {
        return $this->map(self::METHODS, $pattern, $callable);
    }

    /**
     * @param   mixed $request
     * @return  RouterInterface
     */
    public function setRequest($request): RouterInterface
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface
    {
        return $this->_request;
    }

    /**
     * @param   mixed $response
     * @return  RouterInterface
     */
    public function setResponse($response): RouterInterface
    {
        $this->_response = $response;
        return $this;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->_response;
    }

    /**
     * Overwrite default error class
     *
     * @param   callable|string $error
     * @return  RouterInterface
     */
    public function setError($error): RouterInterface
    {
        $this->_error = $error;
        return $this;
    }

    /**
     * Get error class or closure
     *
     * @return  callable|object
     */
    public function getError()
    {
        $error = $this->_error;
        // If string inside then we work on class
        if (\is_string($error)) {
            $error = new $error();
        }
        return $error;
    }

    /**
     * Add route into the array of routes
     *
     * @param   RouteInterface $route
     * @return  RouterInterface
     */
    public function setRoute(RouteInterface $route): RouterInterface
    {
        $regexp = $route->getRegexp();
        $this->_routes[$regexp] = $route;
        return $this;
    }

    /**
     * Find optimal route from array of routes by regexp and uri
     *
     * @return  array
     */
    private function getMatches(): array
    {
        // Extract URI of current query
        $uri = $this->getRequest()->getUri()->getPath();

        // Extract method of current request
        $method = $this->getRequest()->getMethod();
        $method = strtolower($method);

        // Foreach emulation
        return array_map(
            function($regexp, $route) use ($uri, $method) {
                $match = preg_match_all($regexp, $uri, $matches);

                // If something found and method is correct
                if ($match && $route->checkMethod($method)) {
                    // Set array of variables
                    $route->setVariables($matches);
                    return $route;
                }
                return null;
            },
            // Array with keys
            $this->getRoutes(true),
            // Array with values
            $this->getRoutes()
        );
    }

    /**
     * Parse URI by Regexp from routes and return single route
     *
     * @return  RouteInterface
     */
    public function getRoute(): RouteInterface
    {
        // Find route by regexp and URI
        $matches = $this->getMatches();

        // Cleanup the array of matches, then reindex array
        $matches = array_values(array_filter($matches));

        // If we have some classes in result of regexp
        $result = !empty($matches)
            // Take first from matches
            ? $matches[0] // Here the Route() object
            // Create new object with error inside
            : $this->getError();

        $result->setRequest($this->getRequest());
        $result->setResponse($this->getResponse());

        return $result;
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

}
