<?php

namespace DrMVC\Router;

use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;

/**
 * Class Route
 * @package DrMVC
 */
class Route implements Interfaces\Route
{
    /**
     * @var array
     */
    private $_variables = [];

    /**
     * @var string
     */
    private $_regexp;

    /**
     * @var mixed
     */
    private $_callback;

    /**
     * @var \Zend\Diactoros\ServerRequest
     */
    private $_request;

    /**
     * @var \Zend\Diactoros\Response
     */
    private $_response;

    /**
     * Route constructor.
     *
     * @param   string $method
     * @param   string $pattern
     * @param   $callable
     * @param   ServerRequest $request
     * @param   Response $response
     */
    public function __construct(
        string $method,
        string $pattern,
        $callable,
        ServerRequest $request = null,
        Response $response = null
    ) {
        $this->setRoute($method, $pattern, $callable, $request, $response);
    }

    /**
     * Set variables of current class
     *
     * @param   array $variables
     */
    public function setVariables(array $variables)
    {
        $this->_variables = $variables;
    }

    /**
     * Return array of available variables
     *
     * @return  array
     */
    public function getVariables(): array
    {
        return $this->_variables;
    }

    /**
     * Set single route
     *
     * @param   string $method
     * @param   string $pattern
     * @param   mixed $callable
     * @return  Interfaces\Route
     */
    public function setRoute(string $method, string $pattern, $callable): Interfaces\Route
    {
        return $this
            ->setRegexp($pattern)
            ->setCallback($callable);
    }

    /**
     * @param   mixed $request
     * @return  Interfaces\Route
     */
    public function setRequest($request): Interfaces\Route
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * @return ServerRequest
     */
    public function getRequest(): ServerRequest
    {
        return $this->_request;
    }

    /**
     * @param   mixed $response
     * @return  Interfaces\Route
     */
    public function setResponse($response): Interfaces\Route
    {
        $this->_response = $response;
        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->_response;
    }

    /**
     * Set callable element or class
     *
     * @param   mixed $callback
     * @return  Interfaces\Route
     */
    public function setCallback($callback): Interfaces\Route
    {
        $this->_callback = $callback;
        return $this;
    }

    /**
     * Return callable element
     *
     * @return  Interfaces\Callback
     */
    public function getCallback(): Interfaces\Callback
    {
        return $this->_callback;
    }

    /**
     * Set regexp of current route
     *
     * @param   string $regexp
     * @return  Interfaces\Route
     */
    public function setRegexp(string $regexp): Interfaces\Route
    {
        $pattern = ['/</', '/>/'];
        $replace = ['(?P<', '>.+)'];
        $regexp = preg_replace($pattern, $replace, $regexp);
        $this->_regexp = '#^' . $regexp . '$#u';
        return $this;
    }

    /**
     * Return regexp of current route
     *
     * @return  string
     */
    public function getRegexp(): string
    {
        return $this->_regexp;
    }

}