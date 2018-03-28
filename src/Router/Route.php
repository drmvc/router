<?php

namespace DrMVC\Router;

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
     * @var Interfaces\Callback
     */
    private $_callback;

    /**
     * Route constructor.
     *
     * @param   string $method
     * @param   string $pattern
     * @param   callable|string $callable
     */
    public function __construct(string $method, string $pattern, $callable)
    {
        $this->setRoute($method, $pattern, $callable);
    }

    /**
     * @param array $variables
     */
    public function setVariables(array $variables)
    {
        $this->_variables = $variables;
    }

    /**
     * Set some new variable
     *
     * @param   string $key
     * @param   string $value
     * @return  Interfaces\Route
     */
    public function setVariable(string $key, string $value): Interfaces\Route
    {
        $this->_variables[$key] = $value;
        return $this;
    }

    /**
     * Get some variable by name
     *
     * @param   string $key
     * @return  string
     */
    public function getVariable(string $key): string
    {
        return $this->_variables[$key];
    }

    /**
     * Return a list of variables
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
     * @param   callable|string $callable
     * @return  Interfaces\Route
     */
    public function setRoute(string $method, string $pattern, $callable): Interfaces\Route
    {
        return $this
            ->setRegexp($pattern)
            ->setCallable($callable);
    }

    /**
     * Set callable element or class
     *
     * @param   callable|string $callable
     * @return  Interfaces\Route
     */
    public function setCallable($callable): Interfaces\Route
    {
        $this->_callback = new Callback($callable);
        return $this;
    }

    /**
     * Return callable element
     *
     * @return  Interfaces\Callback
     */
    public function getCallable()
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

    /**
     * Call required closure or class
     */
    public function execute()
    {
        return $this->getCallable()->execute($this->getVariables());
    }
}