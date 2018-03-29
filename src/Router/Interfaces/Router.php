<?php

namespace DrMVC\Router\Interfaces;

use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;

interface Router
{
    /**
     * List of all available methods
     */
    const METHODS = ['get', 'post', 'put', 'update', 'delete', 'option'];

    /**
     * @param   mixed $request
     * @return  Router
     */
    public function setRequest($request): Router;

    /**
     * @return ServerRequest
     */
    public function getRequest(): ServerRequest;

    /**
     * @param   mixed $response
     * @return  Router
     */
    public function setResponse($response): Router;

    /**
     * @return  Response
     */
    public function getResponse(): Response;

    /**
     * Custom error callback of class
     *
     * @param   callable|string $error
     * @return  Router
     */
    public function setError($error): Router;

    /**
     * Get current error object
     * @return callable|string
     */
    public function getError();

    /**
     * Parse URI by Regexp from routes and return single route
     *
     * @return  Route
     */
    public function getRoute();

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
     * Add route into the array of routes
     *
     * @param   Route $route
     * @return  Router
     */
    public function setRoute(Route $route): Router;

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