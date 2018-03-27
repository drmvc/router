<?php namespace DrMVC\Exceptions;

class ArrayException extends Exception
{
    /**
     * @param   mixed $value
     * @param   array $array
     * @throws  ArrayException
     */
    public static function inArray($value, $array)
    {
        if (!in_array($value, $array)) {
            throw new ArrayException("Value \"$value\" not in array");
        }
    }
}