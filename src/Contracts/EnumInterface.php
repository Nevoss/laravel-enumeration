<?php

namespace Nevoss\Enumeration\Contracts;

use Nevoss\Enumeration\Exceptions\InvalidValueException;

interface EnumInterface
{
    /**
     * Enum constructor.
     *
     * @param mixed $value
     */
    public function __construct($value = null);
    
    /**
     * check if the provide variable is equals to value of the enum
     *
     * @param $value
     * @return bool
     */
    public function equals($value);
    
    /**
     * same as equals
     *
     * @param $value
     * @return bool
     */
    public function is($value);
    
    /**
     * Set value
     *
     * @param $value
     * @return $this
     * @throws InvalidValueException
     */
    public function setValue($value = null);
    
    /**
     * get value
     *
     * @return mixed
     */
    public function getValue();
    
    /**
     * returns the label of the enums value
     *
     * @return mixed
     */
    public function getLabel();
    
    /**
     * returns all the values of the current static enum class
     *
     * @return \Illuminate\Support\Collection
     */
    public static function values();
    
    /**
     * returns all the constants names
     *
     * @return \Illuminate\Support\Collection
     */
    public static function keys();
    
    /**
     * returns all the labels of the enum
     *
     * @return \Illuminate\Support\Collection
     */
    public static function labels();
    
    /**
     * returns all the values as an enum class
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all();
    
    /**
     * check if the value is a valid enum value
     *
     * @param $value
     * @return bool
     */
    public static function isValid($value);
    
    /**
     * create an instance of the enum class
     *
     * @param $value
     * @return static
     */
    public static function create($value);
    
    /**
     * generate an instance of enum class base on the name of the method
     * e.g: PostStatusEnum::DRAFT() when DRAFT is en enum value
     *
     * @param $methodName
     * @param $arguments
     * @return static
     */
    public static function __callStatic($methodName, $arguments);
}
