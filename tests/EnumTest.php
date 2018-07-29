<?php

namespace Nevoss\Enumeration\Test;

use Illuminate\Support\Collection;
use Nevoss\Enumeration\Exceptions\InvalidPropertyException;
use Nevoss\Enumeration\Exceptions\InvalidValueException;
use Nevoss\Enumeration\Test\Stubs\PostStatusEnumStub;

class EnumTest extends TestCase
{
    /** @test */
    public function it_can_returns_the_value_of_the_enum()
    {
        $enum = new PostStatusEnumStub(PostStatusEnumStub::PUBLISH);
    
        $this->assertEquals('publish', $enum->getValue());
        $this->assertEquals('publish', $enum->value);
    }
    
    /** @test */
    public function it_can_returns_the_label_of_the_enum()
    {
        $enum = new PostStatusEnumStub(PostStatusEnumStub::PUBLISH);
        
        $this->assertEquals('Published', $enum->getLabel());
        $this->assertEquals('Published', $enum->label);
    }
    
    /** @test */
    public function value_can_be_set()
    {
        $enum = new PostStatusEnumStub(PostStatusEnumStub::PUBLISH);
        
        $enum->setValue(PostStatusEnumStub::DRAFT);
        $this->assertEquals($enum, new PostStatusEnumStub(PostStatusEnumStub::DRAFT));
        
        $enum->value = PostStatusEnumStub::PENDING;
        $this->assertEquals($enum, new PostStatusEnumStub(PostStatusEnumStub::PENDING));
    }
    
    /** @test */
    public function it_throws_exception_if_the_value_is_not_in_the_options()
    {
        $this->expectException(InvalidValueException::class);
    
        $enum = new PostStatusEnumStub(PostStatusEnumStub::PUBLISH);
    
        $enum->setValue(5555555555555);
    }
    
    /** @test */
    public function it_throws_exception_if_trying_access_invalid_property()
    {
        $this->expectException(InvalidPropertyException::class);
    
        $enum = new PostStatusEnumStub(PostStatusEnumStub::PUBLISH);
        
        $enum->somthing;
    }
    
    /** @test */
    public function it_throws_exception_if_trying_set_invalid_property()
    {
        $this->expectException(InvalidPropertyException::class);
        
        $enum = new PostStatusEnumStub(PostStatusEnumStub::PUBLISH);
        
        $enum->somthing = PostStatusEnumStub::PUBLISH;
    }
    
    /** @test */
    public function it_can_be_serialize_to_json()
    {
        $enum = new PostStatusEnumStub(PostStatusEnumStub::DRAFT);
        
        $this->assertArraySubset([
            'value' => 'draft',
            'label' => 'Draft Mode'
        ] ,json_decode(json_encode($enum), true));
    }
    
    /** @test */
    public function it_can_validate_a_value()
    {
        $this->assertTrue(PostStatusEnumStub::isValid(PostStatusEnumStub::DRAFT));
        $this->assertTrue(PostStatusEnumStub::isValid(PostStatusEnumStub::PUBLISH));
        $this->assertTrue(PostStatusEnumStub::isValid(PostStatusEnumStub::PENDING));
        $this->assertFalse(PostStatusEnumStub::isValid('Try'));
        $this->assertFalse(PostStatusEnumStub::isValid(111));
    }
    
    /** @test */
    public function it_can_get_all_the_enums_options_in_collection()
    {
        $enums = PostStatusEnumStub::all();
        
        $this->assertInstanceOf(Collection::class, $enums);
        $enums->each(function ($enum) {
            $this->assertInstanceOf(PostStatusEnumStub::class, $enum);
        });
    }
}
