<?php

namespace DrMVC\Router;

use DrMVC\Exceptions\LogicException;

class Callback implements Interfaces\Callback
{
    /**
     * @var mixed
     */
    private $_callback;

    /**
     * Callback constructor.
     * @param mixed $callback
     */
    public function __construct($callback)
    {
        $this->setCallback($callback);
    }

    /**
     * @param mixed $callback
     */
    public function setCallback($callback)
    {
        $this->_callback = $callback;
    }

    /**
     * @return mixed
     */
    public function getCallback()
    {
        return $this->_callback;
    }

    /**
     * @param   string $callable
     * @return  mixed
     */
    public function callClass(string $callable, array $args = [])
    {
        // Parse callable to elements
        $callable = explode(':', $callable);

        try {
            if (!isset($callable[0])) {
                throw new LogicException('Class name is not set');
            }
        } catch (LogicException $e) {
        }

        // Get name of class
        $className = $callable[0];

        // Initiate object of class
        $classObject = new $className();

        // Set default method or method from route
        $classMethod = !isset($callable[1])
            ? Route::DEFAULT_ACTION
            : $callable[1];

        // Create normal name of action
        $classAction = 'action_' . $classMethod;

        try {
            if (!method_exists($classObject, $classAction)) {
                throw new LogicException("Method \"$classAction\" does not exist in \"$className\" class");
            }
        } catch (LogicException $e) {
        }

        // Create new class and call action
        return $classObject->$classAction($args);
    }

    /**
     * Call required closure or class
     *
     * @param   array $args
     * @return  mixed
     */
    public function execute(array $args = [])
    {
        $callable = $this->getCallback();

        // If we get a string, then class given
        if (is_string($callable)) {
            return $this->callClass($callable, $args);
        }

        // If we have a normal callable element
        if (is_callable($callable)) {
            return $callable($args);
        }

        return false;
    }
}