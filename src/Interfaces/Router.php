<?php namespace DrMVC\Interfaces;

interface Router
{
    /**
     * List of all available methods
     */
    const METHODS = ['get', 'post', 'put', 'update', 'delete', 'option'];

    /**
     * Parse URI by Regexp from routes
     *
     * @return  Route
     */
    public function parse();

    /**
     * GET method
     *
     * @param   string $pattern
     * @param   callable $callable
     * @return  Router
     */
    public function get(string $pattern, callable $callable): Router;

    /**
     * POST method
     *
     * @param   string $pattern
     * @param   callable $callable
     * @return  Router
     */
    public function post(string $pattern, callable $callable): Router;

    /**
     * PUT method
     *
     * @param   string $pattern
     * @param   callable $callable
     * @return  Router
     */
    public function put(string $pattern, callable $callable): Router;

    /**
     * DELETE method
     *
     * @param   string $pattern
     * @param   callable $callable
     * @return  Router
     */
    public function delete(string $pattern, callable $callable): Router;

    /**
     * OPTION method
     *
     * @param   string $pattern
     * @param   callable $callable
     * @return  Router
     */
    public function option(string $pattern, callable $callable): Router;

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