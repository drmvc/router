<?php

namespace DrMVC\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface RouterInterface
 * @package DrMVC\Router
 * @since 3.0
 */
interface RouterInterface
{
    /**
     * Abstraction of setter
     *
     * @param   array $methods
     * @param   array $args
     * @return  RouterInterface
     */
    public function set(array $methods, array $args): RouterInterface;

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
     * @return callable|object
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
