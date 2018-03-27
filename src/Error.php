<?php namespace DrMVC;

class Error implements Interfaces\Error
{
    public function execute()
    {
        echo "Page not found\n";
    }
}