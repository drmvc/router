<?php

namespace Router;

use DrMVC\Router\Exception;
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{

    public function test__construct()
    {
        $this->expectException(Exception::class);
        throw new Exception('Test call of Exception');
    }
}
