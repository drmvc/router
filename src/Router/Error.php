<?php

namespace DrMVC\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Error
 * @package DrMVC\Router
 */
class Error extends Route
{
    public function __construct(array $methods = ['get'], string $regexp = 'error', $callable = '')
    {
        parent::__construct($methods, $regexp, $callable);
    }
}
