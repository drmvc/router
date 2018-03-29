<?php

namespace DrMVC\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface RouteInterface
 * @package DrMVC\Router\Interfaces
 */
interface RouteInterface
{
    const DEFAULT_ACTION = 'index';

    /**
     * Set PSR-7 request
     *
     * @param   ServerRequestInterface $request PSR-7 request
     * @return  RouteInterface
     */
    public function setRequest(ServerRequestInterface $request = null): RouteInterface;

    /**
     * Get PSR-7 request
     *
     * @return  ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface;

    /**
     * Set PSR-7 response
     *
     * @param   ResponseInterface $response RSP-7 response
     * @return  RouteInterface
     */
    public function setResponse(ResponseInterface $response = null): RouteInterface;

    /**
     * Get PSR-7 response
     *
     * @return  ResponseInterface
     */
    public function getResponse(): ResponseInterface;

    /**
     * Set variables of current class
     *
     * @param   array $variables
     * @return  RouteInterface
     */
    public function setVariables(array $variables): RouteInterface;

    /**
     * Return array of available variables
     *
     * @return  array
     */
    public function getVariables(): array;

    /**
     * Set callable element or class
     *
     * @param   callable|string $callback
     * @return  RouteInterface
     */
    public function setCallback($callback): RouteInterface;

    /**
     * Return callable element
     *
     * @return  callable|string
     */
    public function getCallback();

    /**
     * Set regexp of current route
     *
     * @param   string $regexp
     * @return  RouteInterface
     */
    public function setRegexp(string $regexp): RouteInterface;

    /**
     * Return regexp of current route
     *
     * @return  string
     */
    public function getRegexp(): string;

    /**
     * Set single route
     *
     * @param   string $method Method of received query
     * @param   string $regexp Regular expression
     * @param   callable|string $callable Class name or callback
     * @return  RouteInterface
     */
    public function setRoute(
        string $method,
        string $regexp,
        $callable
    ): RouteInterface;

}
