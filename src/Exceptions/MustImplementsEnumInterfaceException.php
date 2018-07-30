<?php

namespace Nevoss\Enumeration\Exceptions;

use Nevoss\Enumeration\Contracts\EnumInterface;

class MustImplementsEnumInterfaceException extends \InvalidArgumentException
{
    /**
     * create Exception
     *
     * @param string $className
     * @return static
     */
    public static function create(string $className)
    {
        $interfaceClassName = EnumInterface::class;
        
        return new static("`{$className}` must implements `{$interfaceClassName}`");
    }
}
