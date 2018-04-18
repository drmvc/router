<?php

namespace Router;

use DrMVC\Router\Error;
use PHPUnit\Framework\TestCase;

class ErrorTest extends TestCase
{

    public function test__construct()
    {
        $error = new Error();
        $this->assertInternalType('object', $error);
        $this->assertInstanceOf(Error::class, $error);
    }
}
