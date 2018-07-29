<?php

namespace Nevoss\Enumeration\Contracts;

use Illuminate\Support\Collection;

interface EnumInterface
{
    /**
     * returns the value of the option
     *
     * @return mixed
     */
    public function getValue();
    
    /**
     * Set value
     *
     * @param $value
     * @return $this
     */
    public function setValue($value);
    
    /**
     * returns the label of the enum value
     *
     * @return mixed
     */
    public function getLabel();
    
    /**
     * check if value is exists in the enum options
     *
     * @param $value
     * @return bool
     */
    public static function isValid($value): bool;
    
    /**
     * returns a collections of all the options of the enum
     *
     * @return Collection
     */
    public static function all(): Collection;
}
