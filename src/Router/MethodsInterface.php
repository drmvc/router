<?php

namespace DrMVC\Router;

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
     * @return  MethodsInterface
     */
    public function __call(string $method, array $args): MethodsInterface;

    /**
     * Any method should be callable
     *
     * @param   string $pattern
     * @param   callable|string $callable
     * @return  MethodsInterface
     */
    public function any(string $pattern, $callable): MethodsInterface;

    /**
     * Callable must be only selected methods
     *
     * @param   array $methods
     * @param   string $pattern
     * @param   callable|string $callable
     * @return  MethodsInterface
     */
    public function map(array $methods, string $pattern, $callable): MethodsInterface;

    /**
     * Group routes
     *
     * @param   string $pattern
     * @param   callable|string $callable
     * @return  MethodsInterface
     */
    // TODO: Implement this method
    //public function group(string $pattern, $callable): MethodsInterface;

    /**
     * Set error method
     *
     * @param   callable|string $callable
     * @return  MethodsInterface
     */
    public function error($callable): MethodsInterface;
}
