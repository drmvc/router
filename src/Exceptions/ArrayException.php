<?php

namespace DrMVC\Exceptions;

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
            throw new ArrayException("Value \"$value\" is not in array");
        }
    }

    /**
     * @param   $array
     * @throws  ArrayException
     */
    public static function isArray($array)
    {
        if (!is_array($array)) {
            throw new ArrayException("Value \"$array\" is not array");
        }
    }

    /**
     * @param   int $num
     * @param   array $array
     * @throws  ArrayException
     */
    public static function arrayCount(int $num, array $array)
    {
        $count = count($array);
        if ($count != $num) {
            throw new ArrayException("Values count \"$count\" but should be \"$num\"");
        }
    }
}