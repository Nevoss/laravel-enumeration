<?php

namespace Nevoss\Enumeration;

use Illuminate\Support\Collection;
use Nevoss\Enumeration\Contracts\EnumInterface;
use Nevoss\Enumeration\Exceptions\InvalidPropertyException;
use Nevoss\Enumeration\Exceptions\InvalidValueException;

abstract class Enum implements EnumInterface, \JsonSerializable
{
    /**
     * hold all values in keys and the labels value
     *
     * @var array
     */
    public static $optionsLabels = [];
    
    /**
     * Hold the current value of the enum
     *
     * @var mixed
     */
    protected $value;
    
    /**
     * Enum constructor.
     *
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        $this->setValue($value);
    }
    
    /**
     * Set value
     *
     * @param $value
     * @return $this
     * @throws InvalidValueException
     */
    public function setValue($value = null)
    {
        if ($value !== null && !static::isValid($value)) {
            throw InvalidValueException::create($value, static::class);
        }
    
        $this->value = $value;
    
        return $this;
    }
    
    /**
     * get value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * returns the label of the enums value
     *
     * @return mixed
     */
    public function getLabel()
    {
        if ($this->value === null) {
            return null;
        }
        
        return static::$optionsLabels[$this->value];
    }
    
    /**
     * Dynamically retrieve value or label on Enum.
     *
     * @param $key
     * @return mixed
     * @throws InvalidPropertyException
     */
    public function __get($key)
    {
        $methodName = 'get' . ucfirst($key);
        
        if (!method_exists($this, $methodName)) {
            throw InvalidPropertyException::get($key, static::class);
        }
        
        return $this->{$methodName}();
    }
    
    /**
     * Dynamically set value on Enum.
     *
     * @param $key
     * @param $value
     * @return mixed
     * @throws InvalidPropertyException
     */
    public function __set($key, $value)
    {
        $methodName = 'set' . ucfirst($key);
    
        if (!method_exists($this, $methodName)) {
            throw InvalidPropertyException::set($key, static::class);
        }
    
        return $this->{$methodName}($value);
    }
    
    /**
     * Determine if an property exists on the Enum.
     *
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->{$key});
    }
    
    /**
     * cast the object on calling json_encode function
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'value' => $this->getValue(),
            'label' => $this->getLabel(),
        ];
    }
    
    /**
     * check if value is exists in the enum options
     *
     * @param $value
     * @return bool
     */
    public static function isValid($value): bool
    {
        if (!array_key_exists($value, static::$optionsLabels)) {
            return false;
        }
    
        return true;
    }
    
    /**
     * returns collection of all the enum options
     *
     * @return Collection
     */
    public static function all(): Collection
    {
        return collect(static::$optionsLabels)
            ->keys()
            ->map(function ($value) {
                return new static($value);
            });
    }
}
