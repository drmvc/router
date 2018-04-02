<?php

namespace DrMVC\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Route
 * @package DrMVC\Router
 * @since 3.0
 */
class Route implements RouteInterface
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
     * @var ServerRequestInterface
     */
    private $_request;

    /**
     * @var ResponseInterface
     */
    private $_response;

    /**
     * @var array
     */
    private $_methods = [];

    /**
     * Route constructor.
     *
     * @param   array $methods Method of received query
     * @param   string $regexp Regular expression
     * @param   callable|string $callable Class name or callback
     * @param   ServerRequestInterface $request PSR-7 request
     * @param   ResponseInterface $response RSP-7 response
     */
    public function __construct(
        array $methods,
        string $regexp,
        $callable,
        ServerRequestInterface $request = null,
        ResponseInterface $response = null
    ) {
        $this
            ->setRoute($methods, $regexp, $callable)
            ->setRequest($request)
            ->setResponse($response);
    }

    /**
     * Set current method of object
     *
     * @param   array $methods
     * @return  RouteInterface
     */
    public function setMethods(array $methods): RouteInterface
    {
        $this->_methods = $methods;
        return $this;
    }

    /**
     * Get method of current object
     *
     * @return array
     */
    public function getMethods(): array
    {
        return $this->_methods;
    }

    /**
     * Check if method is in set
     *
     * @param   string $method
     * @return  bool
     */
    public function checkMethod(string $method): bool
    {
        return \in_array($method, $this->getMethods(), false);
    }

    /**
     * Set variables of current class
     *
     * @param   array $variables
     * @return  RouteInterface
     */
    public function setVariables(array $variables): RouteInterface
    {
        $this->_variables = $variables;
        return $this;
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
     * @param   array $methods Method of received query
     * @param   string $regexp Regular expression
     * @param   callable|string $callable Class name or callback
     * @return  RouteInterface
     */
    public function setRoute(
        array $methods,
        string $regexp,
        $callable
    ): RouteInterface {
        return $this
            ->setMethods($methods)
            ->setRegexp($regexp)
            ->setCallback($callable);
    }

    /**
     * Set PSR-7 request
     *
     * @param   ServerRequestInterface $request - PSR-7 request
     * @return  RouteInterface
     */
    public function setRequest(ServerRequestInterface $request = null): RouteInterface
    {
        if (null !== $request) {
            $this->_request = $request;
        }
        return $this;
    }

    /**
     * Get PSR request
     *
     * @return  ServerRequestInterface|null
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * Set RSR response
     *
     * @param   mixed $response
     * @return  RouteInterface
     */
    public function setResponse(ResponseInterface $response = null): RouteInterface
    {
        if (!empty($response)) {
            $this->_response = $response;
        }
        return $this;
    }

    /**
     * Get RSR-7 response
     *
     * @return  ResponseInterface|null
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Set callable element or class
     *
     * @param   mixed $callback
     * @return  RouteInterface
     */
    public function setCallback($callback): RouteInterface
    {
        $this->_callback = $callback;
        return $this;
    }

    /**
     * Return callable element
     *
     * @return  callable|string
     */
    public function getCallback()
    {
        return $this->_callback;
    }

    /**
     * Set regexp of current route
     *
     * @param   string $regexp
     * @return  RouteInterface
     */
    public function setRegexp(string $regexp): RouteInterface
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
