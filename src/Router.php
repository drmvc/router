<?php namespace DrMVC;

use DrMVC\Interfaces\Route as RouteInterface;
use DrMVC\Interfaces\Url as UrlInterface;
use DrMVC\Exceptions\ArrayException;

class Router implements Interfaces\Router
{
    /**
     * Current URL
     * @var Url
     */
    private $_url;

    /**
     * Array with all available routes
     * @var array
     */
    private $_routes = [];

    public function __construct(UrlInterface $url)
    {
        if ($url instanceof UrlInterface) {
            $this->setUrl($url);
        }

        // TODO: Add this
//        if ($url === true) {
//            $url = Url::autodetect();
//            $this->setUrl($url);
//        }
    }

    /**
     * Parse URI by Regexp from routes
     *
     * @return  Interfaces\Route|Interfaces\Error
     */
    public function parse()
    {
        // Find route by regexp and URI
        $matches = array_map(
            function ($pattern, $route) {
                $uri = $this->_url->getUri();

                return preg_match($pattern, $uri)
                    ? $route
                    : null;
            },
            $this->getRoutes(true),
            $this->getRoutes()
        );

        // Cleanup the array of matches
        $matches = array_filter($matches);

        // Return first match of false
        return !empty($matches)
            ? $matches[0]
            : new Error();
    }

    /**
     * Abstraction of setter
     *
     * @param   string $method
     * @param   string $pattern
     * @param   callable $callable
     * @return  Interfaces\Router
     */
    private function set(string $method, string $pattern, callable $callable)
    {
        $route = new Route($method, $pattern, $callable);
        $this->setRoute($route);
        return $this;
    }

    /**
     * Set current URL into the variable
     *
     * @param   UrlInterface $url
     * @return  Router
     */
    private function setUrl(UrlInterface $url): Interfaces\Router
    {
        $this->_url = $url;
        return $this;
    }

    /**
     * Add route into the array of routes
     *
     * @param   RouteInterface $route
     */
    private function setRoute(RouteInterface $route)
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
     * GET method
     *
     * @param   string $pattern
     * @param   callable $callable
     * @return  Interfaces\Router
     */
    public function get(string $pattern, callable $callable): Interfaces\Router
    {
        return $this->set('get', $pattern, $callable);
    }

    /**
     * POST method
     *
     * @param   string $pattern
     * @param   callable $callable
     * @return  Interfaces\Router
     */
    public function post(string $pattern, callable $callable): Interfaces\Router
    {
        return $this->set('post', $pattern, $callable);
    }

    /**
     * PUT method
     *
     * @param   string $pattern
     * @param   callable $callable
     * @return  Interfaces\Router
     */
    public function put(string $pattern, callable $callable): Interfaces\Router
    {
        return $this->set('put', $pattern, $callable);
    }

    /**
     * DELETE method
     *
     * @param   string $pattern
     * @param   callable $callable
     * @return  Interfaces\Router
     */
    public function delete(string $pattern, callable $callable): Interfaces\Router
    {
        return $this->set('delete', $pattern, $callable);
    }

    /**
     * OPTION method
     *
     * @param   string $pattern
     * @param   callable $callable
     * @return  Interfaces\Router
     */
    public function option(string $pattern, callable $callable): Interfaces\Router
    {
        return $this->set('delete', $pattern, $callable);
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
            function ($method) use ($pattern, $callable) {
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