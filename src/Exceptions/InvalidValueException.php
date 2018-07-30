<?php

namespace Nevoss\Enumeration\Exceptions;

class InvalidValueException extends \UnexpectedValueException
{
    /**
     * create Exception
     *
     * @param mixed $value
     * @param string $className
     * @return static
     */
    public static function create($value, string $className)
    {
        return new static("`{$value}` is invalid value for enum class: `{$className}`");
    }
}
