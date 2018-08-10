<?php

namespace Nevoss\Enumeration;

use Nevoss\Enumeration\Contracts\EnumInterface;
use Nevoss\Enumeration\Exceptions\InvalidPropertyException;
use Nevoss\Enumeration\Exceptions\InvalidValueException;

abstract class Enum implements EnumInterface, \JsonSerializable
{
    /**
     * current value of the enum
     *
     * @var mixed
     */
    protected $value;
    
    /**
     * Store all the values labels
     *
     * @var array
     */
    protected static $labels = [];
    
    /**
     * Store all cached labels after it calculate them first time
     *
     * @var array
     */
    protected static $cachedLabels = [];
    
    /**
     * Store cached constant of the current object
     *
     * @var array
     */
    protected static $cachedValues = [];
    
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
     * check if the provide variable is equals to value of the enum
     *
     * @param $value
     * @return bool
     */
    public function equals($value)
    {
        if ($value instanceof static) {
            $value = $value->getValue();
        }
        
        return $value === $this->getValue();
    }
    
    /**
     * same as equals
     *
     * @param $value
     * @return bool
     */
    public function is($value)
    {
        return $this->equals($value);
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
        return static::labels()->get($this->value, null);
    }
    
    /**
     * returns all the values of the current static enum class
     *
     * @return \Illuminate\Support\Collection
     */
    public static function values()
    {
        if (empty(static::$cachedValues)) {
            $reflectionClass = new \ReflectionClass(static::class);
            static::$cachedValues = $reflectionClass->getConstants();
        }
        
        return collect(static::$cachedValues);
    }
    
    /**
     * returns all the constants names
     *
     * @return \Illuminate\Support\Collection
     */
    public static function keys()
    {
        return static::values()->keys();
    }
    
    /**
     * returns all the labels of the enum
     *
     * @return \Illuminate\Support\Collection
     */
    public static function labels()
    {
        if (static::$cachedLabels) {
            return collect(static::$cachedLabels);
        }
        
        return static::values()->flip()->map(function ($value, $key) {
            
            $label = array_key_exists($key, static::$labels) ?
                static::$labels[$key] :
                str_replace('_', ' ', ucfirst(strtolower($value)));
            
            return static::$cachedLabels[$key] = $label;
        });
    }
    
    /**
     * returns all the values as an enum class
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all()
    {
        return static::values()->map(function ($value) {
            return new static($value);
        });
    }
    
    /**
     * check if the value is a valid enum value
     *
     * @param $value
     * @return bool
     */
    public static function isValid($value)
    {
        if ($value instanceof static) {
            $value = $value->value;
        }
        
        return static::values()->contains($value);
    }
    
    /**
     * create an instance of the enum class
     *
     * @param $value
     * @return static
     */
    public static function create($value)
    {
        return new static($value);
    }
    
    /**
     * generate an instance of enum class base on the name of the method
     * e.g: PostStatusEnum::DRAFT() when DRAFT is en enum value
     *
     * @param $methodName
     * @param $arguments
     * @return static
     */
    public static function __callStatic($methodName, $arguments)
    {
        if (static::keys()->contains($methodName)) {
            return static::create(\constant(static::class . '::' . $methodName));
        }
    
        throw new \BadMethodCallException("Method `{$methodName}` not founded in class " . static::class);
    }
    
    /**
     * check and execute "is" methods, e.g: isDraft check if the current enum class
     * is equals to DRAFT enum value
     *
     * @param $methodName
     * @param $arguments
     * @return bool
     */
    public function __call($methodName, $arguments)
    {
        if (
            strpos($methodName, 'is') === 0 &&
            static::keys()->contains($key = strtoupper(snake_case(substr($methodName, 2))))
        ) {
            return $this->equals(\constant(static::class . '::' . $key));
        }
        
        throw new \BadMethodCallException("Method `{$methodName}` not founded in class " . static::class);
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
     * cast the object when calling json_encode function on current enum class
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
}
