<?php

namespace DrMVC\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface RouterInterface
 * @package DrMVC\Router
 */
interface RouterInterface
{
    /**
     * List of all available methods
     */
    const METHODS = ['get', 'post', 'put', 'update', 'delete', 'option'];

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
     * Set PSR-7 request
     *
     * @param   ServerRequestInterface $request - PSR-7 request
     * @return  RouterInterface
     */
    public function setRequest($request): RouterInterface;

    /**
     * Get PSR-7 request
     *
     * @return  ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface;

    /**
     * @param   mixed $response
     * @return  RouterInterface
     */
    public function setResponse($response): RouterInterface;

    /**
     * @return  ResponseInterface
     */
    public function getResponse(): ResponseInterface;

    /**
     * Custom error callback of class
     *
     * @param   callable|string $error
     * @return  RouterInterface
     */
    public function setError($error): RouterInterface;

    /**
     * Get current error object
     * @return callable|string
     */
    public function getError();

    /**
     * Add route into the array of routes
     *
     * @param   RouteInterface $route
     * @return  RouterInterface
     */
    public function setRoute(RouteInterface $route): RouterInterface;

    /**
     * Parse URI by Regexp from routes and return single route
     *
     * @return  RouteInterface
     */
    public function getRoute(): RouteInterface;

    /**
     * Get all available routes
     *
     * @param   bool $keys - Return only keys
     * @return  array
     */
    public function getRoutes(bool $keys = false): array;

}