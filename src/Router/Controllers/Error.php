<?php

namespace DrMVC\Router\Controllers;

/**
 * Class Error - It's a normal controller, but only one page
 * @package DrMVC
 */
class Error
{
    public function action_index()
    {
        http_response_code(404);
        echo "Page not found\n";
    }
}