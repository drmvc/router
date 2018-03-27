<?php namespace DrMVC\Interfaces;

/**
 * Interface Route
 * @package DrMVC\Interfaces
 */
interface Route
{
    const DEFAULT_ACTION = 'index';

    /**
     * Call required closure
     */
    public function execute();

    /**
     * Route constructor.
     *
     * @param   string $method
     * @param   string $regexp
     * @param   callable $callable
     */
    public function __construct(string $method, string $regexp, callable $callable);

    /**
     * Return callable element
     *
     * @return  callable
     */
    public function getCallable(): callable;

    /**
     * Return regexp of current route
     *
     * @return  string
     */
    public function getRegexp(): string;

    /**
     * Set single route
     *
     * @param   string $method
     * @param   string $regexp
     * @param   callable $callable
     * @return  Route
     */
    public function setRoute(string $method, string $regexp, callable $callable): Route;

    /**
     * Get details about current route
     *
     * @return  array
     */
    public function getRoute(): array;
}