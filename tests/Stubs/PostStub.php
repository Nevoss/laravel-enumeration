<?php

namespace Nevoss\Enumeration\Test\Stubs;

use Illuminate\Database\Eloquent\Model;
use Nevoss\Enumeration\Traits\HasEnums;

class PostStub extends Model
{
    use HasEnums;
    
    protected $fillable = [
        'title', 'status',
    ];
    
    /**
     * holds all the emus of the Model
     *
     * @var array
     */
    protected $enums = [
        'status' => PostStatusEnumStub::class
    ];
}
