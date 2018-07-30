<?php

namespace Nevoss\Enumeration\Exceptions;

class InvalidPropertyException extends \InvalidArgumentException
{
    /**
     * cannot get property in class
     *
     * @param string $property
     * @param string $className
     * @return static
     */
    public static function get(string $property, string $className)
    {
        return new static("cannot access `{$property}` in class: `{$className}`");
    }
    
    /**
     * cannot get property in class
     *
     * @param string $property
     * @param string $className
     * @return static
     */
    public static function set(string $property, string $className)
    {
        return new static("cannot set `{$property}` in class: `{$className}`");
    }
}
