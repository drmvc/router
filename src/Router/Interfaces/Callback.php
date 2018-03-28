<?php

namespace DrMVC\Router\Interfaces;

interface Callback
{
    /**
     * Call required closure or class
     *
     * @param   array $args
     * @return  mixed
     */
    public function execute(array $args);
}