<?php

namespace DrMVC\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface RouterInterface
 * @package DrMVC\Router
 * @since 3.0
 */
interface MethodsInterface
{
    /**
     * List of all available methods
     */
    const METHODS = ['options', 'get', 'head', 'post', 'put', 'delete', 'trace', 'connect'];

    /**
     * @param   string $method
     * @param   array $args
     * @return  RouterInterface
     */
    public function __call(string $method, array $args): RouterInterface;

    /**
     * Any method should be callable
     *
     * @param   string $pattern
     * @param   callable|string $callable
     * @return  RouterInterface
     */
    public function any(string $pattern, $callable): RouterInterface;

    /**
     * Callable must be only selected methods
     *
     * @param   array $methods
     * @param   string $pattern
     * @param   callable|string $callable
     * @return  RouterInterface
     */
    public function map(array $methods, string $pattern, $callable): RouterInterface;

    /**
     * Group routes
     *
     * @param   string $pattern
     * @param   callable|string $callable
     * @return  RouterInterface
     */
    // TODO: Implement this method
    //public function group(string $pattern, $callable): RouterInterface;

    /**
     * Set error method
     *
     * @param   callable|string $callable
     * @return  RouterInterface
     */
    public function error($callable): RouterInterface;
}
