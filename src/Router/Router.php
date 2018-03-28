<?php

namespace DrMVC\Router;

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
     * Current URL
     * @var Url
     */
    private $_url;

    /**
     * Array with all available routes
     * @var array
     */
    private $_routes = [];

    /**
     * Class with error inside
     * @var callable|string
     */
    private $_error = 'DrMVC\Error';


    public function __construct(Interfaces\Url $url = null)
    {
        if ($url instanceof Interfaces\Url) {
            $this->setUrl($url);
        }

        if ($url === null) {
            $url = (new Url())->autodetect();
            $this->setUrl($url);
        }
    }

    /**
     * Overwrite default error class
     *
     * @param   callable|string $error
     * @return  Interfaces\Router
     */
    public function error($error): Interfaces\Router
    {
        $this->_error = $error;
        return $this;
    }

    /**
     * @return callable|string
     */
    public function getError()
    {
        return $this->_error;
    }

    /**
     * Parse URI by Regexp from routes
     *
     * @return  object
     */
    public function parse()
    {
        // Find route by regexp and URI
        $matches = array_map(
            function ($regexp, $route) {
                $uri = $this->_url->getUri();
                $match = preg_match_all($regexp, $uri, $matches);

                if ($match) {
                    $route->setVariables($matches);
                    return $route;
                } else {
                    return null;
                }
            },
            $this->getRoutes(true),
            $this->getRoutes()
        );

        // Cleanup the array of matches, then reindex array
        $matches = array_values(array_filter($matches));

        return !empty($matches)
            ? $matches[0]   // Here the Route() object
            : new Callback($this->getError());
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
        $route = new Route($method, $pattern, $callable);
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
     * Set current URL into the variable
     *
     * @param   Interfaces\Url $url
     * @return  Interfaces\Router
     */
    private function setUrl(Interfaces\Url $url): Interfaces\Router
    {
        $this->_url = $url;
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