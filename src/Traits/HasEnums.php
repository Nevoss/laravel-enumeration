<?php

namespace Nevoss\Enumeration\Traits;

use Nevoss\Enumeration\Contracts\EnumInterface;
use Nevoss\Enumeration\Exceptions\InvalidEnumPropertyException;
use Nevoss\Enumeration\Exceptions\MustImplementsEnumInterfaceException;

trait HasEnums
{
    /**
     * overwrite setAttribute method of Eloquent model
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if (!$this->isEnumAttributeKey($key)) {
             return parent::setAttribute($key, $value);
        }
        
        $this->validateEnumClass(
            $className = $this->enums[$key]
        );
        
        if (!($value instanceof $className)) {
            $value = new $className($value);
        }
        
        return parent::setAttribute($key, $value->getValue());
    }
    
    /**
     * overwrite getAttribute method of Eloquent model
     *
     * @param $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (!$this->isEnumAttributeKey($key)) {
            return parent::getAttribute($key);
        }
    
        $this->validateEnumClass(
            $className = $this->enums[$key]
        );
        
        return new $className(parent::getAttribute($key));
    }
    
    /**
     * check if the attribute is in the enums array
     *
     * @param $key
     * @return bool
     * @throws InvalidEnumPropertyException
     */
    protected function isEnumAttributeKey($key)
    {
        if (!property_exists($this, 'enums')) {
            throw InvalidEnumPropertyException::notExists(static::class);
        }
        
        if (!\is_array($this->enums)) {
            throw InvalidEnumPropertyException::notAnArray(static::class);
        }
        
        return array_key_exists($key, $this->enums);
    }
    
    /**
     * validate that the class name implements EnumInterface
     *
     * @param $className
     * @throws MustImplementsEnumInterfaceException
     */
    protected function validateEnumClass($className)
    {
        $class = new \ReflectionClass($className);
        
        if (!$class->implementsInterface($interfaceClassName = EnumInterface::class)) {
            throw MustImplementsEnumInterfaceException::create(static::class);
        }
    }
}
