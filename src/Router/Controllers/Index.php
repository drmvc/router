<?php

namespace DrMVC\Router\Controllers;

class Index
{
    public function action_index($args)
    {
        return print_r($args, true);
    }
}