<?php

namespace DrMVC\Router\Interfaces;

/**
 * Interface Route
 * @package DrMVC\Interfaces
 */
interface Route
{
    const DEFAULT_ACTION = 'index';

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
     * @param   string $method
     * @param   string $regexp
     * @param   callable|string $callable
     * @return  Route
     */
    public function setRoute(string $method, string $regexp, $callable): Route;

}