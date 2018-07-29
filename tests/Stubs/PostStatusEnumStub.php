<?php

namespace Nevoss\Enumeration\Test\Stubs;

use Nevoss\Enumeration\Enum;

class PostStatusEnumStub extends Enum
{
    public const DRAFT = 'draft';
    public const PENDING = 'pending';
    public const PUBLISH = 'publish';
    
    /**
     * hold all values in keys and the labels value
     *
     * @var array
     */
    public static $optionsLabels = [
        self::DRAFT => 'Draft Mode',
        self::PENDING => 'Pending Mode',
        self::PUBLISH => 'Published',
    ];
}
