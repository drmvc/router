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
     * Call required closure or class
     */
    public function execute();

    /**
     * Route constructor.
     *
     * @param   string $method
     * @param   string $regexp
     * @param   callable|string $callable
     */
    public function __construct(string $method, string $regexp, $callable);

    /**
     * Return callable element
     *
     * @return  Callback
     */
    public function getCallable();

    /**
     * Set callable element or class
     *
     * @param   callable|string $callable
     * @return  Route
     */
    public function setCallable($callable): Route;

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