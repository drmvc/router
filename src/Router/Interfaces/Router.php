<?php

namespace DrMVC\Router\Interfaces;

interface Router
{
    /**
     * List of all available methods
     */
    const METHODS = ['get', 'post', 'put', 'update', 'delete', 'option'];

    /**
     * Custom error callback of class
     *
     * @param   callable|string $error
     * @return  Router
     */
    public function error($error): Router;

    /**
     * Get current error object
     * @return callable|string
     */
    public function getError();

    /**
     * Parse URI by Regexp from routes
     *
     * @return  Route
     */
    public function parse();

    /**
     * Any method should be callable
     *
     * @param   string $pattern
     * @param   callable $callable
     * @return  Router
     */
    public function any(string $pattern, callable $callable): Router;

    /**
     * Callable must be only selected methods
     *
     * @param   array $methods
     * @param   string $pattern
     * @param   callable $callable
     * @return  Router
     */
    public function map(array $methods, string $pattern, callable $callable): Router;

    /**
     * Get all available routes
     *
     * @param   bool $keys - Return only keys
     * @return  array
     */
    public function getRoutes(bool $keys = false): array;

    /**
     * Group routes
     *
     * @param   string $pattern
     * @param   callable $callable
     * @return  Router
     */
    // TODO: Implement this method
    //public function group(string $pattern, callable $callable): Router;
}