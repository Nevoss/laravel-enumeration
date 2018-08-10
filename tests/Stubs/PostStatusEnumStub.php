<?php

namespace Nevoss\Enumeration\Test\Stubs;

use Nevoss\Enumeration\Enum;

class PostStatusEnumStub extends Enum
{
    public const DRAFT = 'draft';
    public const PENDING = 'pending';
    public const PUBLISH = '1';
    public const TWO_WORDS = 2;
    
    /**
     * hold all values in keys and the labels value
     *
     * @var array
     */
    public static $labels = [
        self::DRAFT => 'Draft Mode',
        self::PENDING => 'Pending Mode',
    ];
}
