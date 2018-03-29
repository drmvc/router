<?php

namespace DrMVC\Router\Interfaces;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface Route
 * @package DrMVC\Interfaces
 */
interface Route
{
    const DEFAULT_ACTION = 'index';

    /**
     * @param   ServerRequestInterface $request - PSR-7 request
     * @return  Route
     */
    public function setRequest(ServerRequestInterface $request): Route;

    /**
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface;

    /**
     * @param   ResponseInterface $response - RSP-7 response
     * @return  Route
     */
    public function setResponse(ResponseInterface $response): Route;

    /**
     * @return  ResponseInterface
     */
    public function getResponse(): ResponseInterface;

    /**
     * Return array of available variables
     *
     * @return  array
     */
    public function getVariables(): array;

    /**
     * Return callable element
     */
    public function getCallback();

    /**
     * Set callable element or class
     *
     * @param   callable|string $callback
     * @return  Route
     */
    public function setCallback($callback): Route;

    /**
     * Return regexp of current route
     *
     * @return  string
     */
    public function getRegexp(): string;

    /**
     * Set regexp of current route
     *
     * @param   string $regexp
     * @return  Route
     */
    public function setRegexp(string $regexp): Route;

    /**
     * Set single route
     *
     * @param   string $method - Method of received query
     * @param   string $regexp - Regular expression
     * @param   $callable - Class name or callback
     * @param   ServerRequestInterface $request - PSR-7 request
     * @param   ResponseInterface $response - RSP-7 response
     * @return  Route
     */
    public function setRoute(
        string $method,
        string $regexp,
        $callable,
        ServerRequestInterface $request,
        ResponseInterface $response
    ): Route;

}