<?php namespace DrMVC;

/**
 * Class Route
 * @package DrMVC
 */
class Route implements Interfaces\Route
{
    /**
     * @var array
     */
    private $_route = [];

    /**
     * @var array
     */
    private $_variables = [];

    /**
     * Route constructor.
     *
     * @param   string $method
     * @param   string $pattern
     * @param   callable $callable
     */
    public function __construct(string $method, string $pattern, callable $callable)
    {
        $this->setRoute($method, $pattern, $callable);
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
     * Call required closure
     */
    public function execute()
    {
        $callable = $this->getCallable();
        // TODO: Insert into closure some variables what we find on parse stage
        $callable();
    }

    /**
     * Set single route
     *
     * @param   string $method
     * @param   string $pattern
     * @param   $callable
     * @return  Interfaces\Route
     */
    public function setRoute(string $method, string $pattern, callable $callable): Interfaces\Route
    {
        $pattern = preg_replace('/\//', '\\\\/', $pattern);
        $this->_route = [
            'regexp' => '/^' . $pattern . '/u',
            'callable' => $callable
        ];
        return $this;
    }

    /**
     * Return callable element
     *
     * @return  callable
     */
    public function getCallable(): callable
    {
        return $this->_route['callable'];
    }

    /**
     * Return regexp of current route
     *
     * @return  string
     */
    public function getRegexp(): string
    {
        return $this->_route['regexp'];
    }

    /**
     * Get details about current route
     *
     * @return  array
     */
    public function getRoute(): array
    {
        return $this->_route;
    }
}