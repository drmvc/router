<?php

namespace DrMVC\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface RouteInterface
 * @package DrMVC\Router
 * @since 3.0
 */
interface RouteInterface
{
    const DEFAULT_ACTION = 'index';

    /**
     * Set current method of object
     *
     * @param   array $methods
     * @return  RouteInterface
     */
    public function setMethods(array $methods): RouteInterface;

    /**
     * Get method of current object
     *
     * @return array
     */
    public function getMethods(): array;

    /**
     * Check if method is in set
     *
     * @param   string $method
     * @return  bool
     */
    public function checkMethod(string $method): bool;

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
     * @param   array $methods Method of received query
     * @param   string $regexp Regular expression
     * @param   callable|string $callable Class name or callback
     * @return  RouteInterface
     */
    public function setRoute(array $methods, string $regexp, $callable): RouteInterface;

}
