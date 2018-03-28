<?php

namespace DrMVC\Router;

class Error extends Route
{
    public function __construct(string $method = 'get', string $pattern = 'error', $callable = __CLASS__)
    {
        parent::__construct($method, $pattern, $callable);
    }
}