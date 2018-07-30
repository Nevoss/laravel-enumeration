<?php

namespace Nevoss\Enumeration\Rules;

use Illuminate\Contracts\Validation\Rule;
use Nevoss\Enumeration\Contracts\EnumInterface;
use Nevoss\Enumeration\Exceptions\EnumerationException;

class ValidEnumValue implements Rule
{
    /**
     * @var string
     */
    protected $enumClassName;
    
    /**
     * ValidEnumValue constructor.
     *
     * @param string $enumClassName
     */
    public function __construct($enumClassName)
    {
        $this->setEnumClassName($enumClassName);
    }
    
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return mixed
     */
    public function passes($attribute, $value)
    {
        return \call_user_func($this->enumClassName . '::isValid', $value);
    }
    
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if (!$validationMessage = trans('validation.valid_enum_value')) {
            $validationMessage = ':attribute must have valid value.';
        }
        
        return $validationMessage;
    }
    
    /**
     * validate and set enum class name
     *
     * @param $enumClassName
     * @return $this
     * @throws EnumerationException
     */
    protected function setEnumClassName($enumClassName)
    {
        $class = new \ReflectionClass($enumClassName);
        if (!$class->implementsInterface(EnumInterface::class)) {
            throw new EnumerationException("\"{$enumClassName}\" must implements EnumInterface");
        }
    
        $this->enumClassName = $enumClassName;
    
        return $this;
    }
}
