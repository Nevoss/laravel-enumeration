<?php

namespace Nevoss\Enumeration\Exceptions;

class InvalidEnumPropertyException extends \InvalidArgumentException
{
    /**
     * create Exception when the $enum property is not exists
     *
     * @param $className
     * @return static
     */
    public static function notExists($className)
    {
        return new static("Property `\$enum` must be exist in class: `{$className}`");
    }
    
    /**
     * create Exception when $enum property is not an array
     *
     * @param $className
     * @return static
     */
    public static function notAnArray($className)
    {
        return new static("Property `\$enum` must be an array in class: `{$className}`");
    }
}
