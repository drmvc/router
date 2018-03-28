<?php

namespace DrMVC\Router;

use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;
use DrMVC\Exceptions\LogicException;

class Callback implements Interfaces\Callback
{
    /**
     * @var mixed
     */
    private $_callback;

    /**
     * Callback constructor.
     * @param   ServerRequest $request
     * @param   Response $response
     * @param   $callback
     */
    public function __construct(ServerRequest $request, Response $response, $callback)
    {
        $this->_callback = $callback;
    }

    /**
     * @param   string $classPath
     * @param   array $args
     * @return  mixed
     */
    public function callClass(string $classPath, array $args = [])
    {
        // Parse callable to elements
        $classPath = explode(':', $classPath);

        try {
            if (!isset($classPath[0])) {
                throw new LogicException('Class name is not set');
            }
        } catch (LogicException $e) {
        }

        // Get name of class
        $className = $classPath[0];

        // Initiate object of class
        $classObject = new $className();

        // Set default method or method from route
        $classMethod = !isset($classPath[1])
            ? Route::DEFAULT_ACTION
            : $classPath[1];

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
        $callable = $this->_callback;

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