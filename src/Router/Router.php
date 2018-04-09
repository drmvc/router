<?php

namespace DrMVC\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Router
 * @package DrMVC\Router
 * @method Router options(string $pattern, callable $callable): Router
 * @method Router get(string $pattern, callable $callable): Router
 * @method Router head(string $pattern, callable $callable): Router
 * @method Router post(string $pattern, callable $callable): Router
 * @method Router put(string $pattern, callable $callable): Router
 * @method Router delete(string $pattern, callable $callable): Router
 * @method Router trace(string $pattern, callable $callable): Router
 * @method Router connect(string $pattern, callable $callable): Router
 * @since 3.0
 */
class Router implements RouterInterface, MethodsInterface
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
     * @return  MethodsInterface
     */
    public function __call(string $method, array $args): MethodsInterface
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
        $route = new Route($methods, $pattern, $callable);
        $this->setRoute($route);
        return $this;
    }

    /**
     * Check if passed methods in allowed list
     *
     * @param   array $methods list of methods for check
     * @return  array
     */
    public function checkMethods(array $methods): array
    {
        return array_map(
            function($method) {
                $method = strtolower($method);

                try {
                    if (!\in_array($method, self::METHODS, false)) {
                        throw new Exception("Method \"$method\" is not in allowed list [" . implode(',',
                                self::METHODS) . ']');
                    }
                } catch (Exception $e) {
                    // Catch empty because __construct overloaded
                }

                return $method;
            },
            $methods
        );
    }

    /**
     * Callable must be only selected methods
     *
     * @param   array $methods
     * @param   string $pattern
     * @param   callable|string $callable
     * @return  MethodsInterface
     */
    public function map(array $methods, string $pattern, $callable): MethodsInterface
    {
        // Check if method in allowed list
        $methods = $this->checkMethods($methods);

        // Set new route with parameters
        $this->set($methods, [$pattern, $callable]);

        return $this;
    }

    /**
     * Any method should be callable
     *
     * @param   string $pattern
     * @param   callable|string $callable
     * @return  MethodsInterface
     */
    public function any(string $pattern, $callable): MethodsInterface
    {
        // Set new route with all methods
        $this->set(self::METHODS, [$pattern, $callable]);

        return $this;
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
     * Set PSR-7 response object
     *
     * @param   mixed $response
     * @return  RouterInterface
     */
    public function setResponse($response): RouterInterface
    {
        $this->_response = $response;
        return $this;
    }

    /**
     * Get PSR-7 response object
     *
     * @return  ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->_response;
    }

    /**
     * Set error method
     *
     * @param   callable|string $error
     * @return  MethodsInterface
     */
    public function error($error): MethodsInterface
    {
        $this->setError($error);
        return $this;
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
     * Find route object by URL nad method
     *
     * @param   string $uri
     * @param   string $method
     * @return  array
     */
    private function checkMatches(string $uri, string $method): array
    {
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
        return $this->checkMatches($uri, $method);
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
