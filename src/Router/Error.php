<?php

namespace DrMVC\Router;

/**
 * Class Error
 * @package DrMVC\Router
 * @since 3.0
 */
class Error extends Route
{
    public function __construct(array $methods = ['get'], string $regexp = 'error', $callable = '')
    {
        parent::__construct($methods, $regexp, $callable);
    }
}
