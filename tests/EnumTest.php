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
        $enum = new PostStatusEnumStub(PostStatusEnumStub::DRAFT);
        
        $this->assertEquals('Draft Mode', $enum->getLabel());
        $this->assertEquals('Draft Mode', $enum->label);
    }
    
    /** @test */
    public function it_generate_label_from_the_enum_const_if_label_not_provided_in_the_labels_array()
    {
        $enum = new PostStatusEnumStub(PostStatusEnumStub::PUBLISH);
    
        $this->assertEquals('Publish', $enum->getLabel());
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
        $this->assertEquals(3, $enums->count());
    }
    
    /** @test */
    public function it_can_check_if_two_enums_are_equals()
    {
        $enum = new PostStatusEnumStub(PostStatusEnumStub::PUBLISH);
        
        $this->assertTrue($enum->equals(PostStatusEnumStub::PUBLISH));
        $this->assertTrue($enum->equals(new PostStatusEnumStub(PostStatusEnumStub::PUBLISH)));
        $this->assertFalse($enum->equals(PostStatusEnumStub::DRAFT));
        $this->assertFalse($enum->equals(new PostStatusEnumStub(PostStatusEnumStub::DRAFT)));
    }
    
    /** @test */
    public function the_is_method_is_the_same_has_equals_method()
    {
        $enum = new PostStatusEnumStub(PostStatusEnumStub::PUBLISH);
    
        $this->assertTrue($enum->is(PostStatusEnumStub::PUBLISH));
        $this->assertTrue($enum->is(new PostStatusEnumStub(PostStatusEnumStub::PUBLISH)));
        $this->assertFalse($enum->is(PostStatusEnumStub::DRAFT));
        $this->assertFalse($enum->is(new PostStatusEnumStub(PostStatusEnumStub::DRAFT)));
    }
    
    /** @test */
    public function it_can_check_for_equals_with_dynamic_method_calls()
    {
        $enum = new PostStatusEnumStub(PostStatusEnumStub::PUBLISH);
        
        $this->assertTrue($enum->isPublish());
        $this->assertFalse($enum->isDraft());
    }
    
    /** @test */
    public function it_can_create_enum_object_with_the_create_method()
    {
        $enum = PostStatusEnumStub::create(PostStatusEnumStub::DRAFT);
    
        $this->assertInstanceOf(PostStatusEnumStub::class, $enum);
    }
    
    /** @test */
    public function it_returns_all_the_labels_of_the_enum_in_collection_with_the_values_as_keys()
    {
        $labels = PostStatusEnumStub::labels();
    
        $this->assertInstanceOf(Collection::class, $labels);
        $this->assertArraySubset([ 'Draft Mode', 'Pending Mode', 'Publish' ], $labels->values()->toArray());
        $this->assertArraySubset([ 'draft', 'pending', 'publish' ], $labels->keys()->toArray());
    }
    
    /** @test */
    public function it_returns_all_the_values_in_collection()
    {
        $values = PostStatusEnumStub::values();
    
        $this->assertInstanceOf(Collection::class, $values);
        $this->assertArraySubset([ 'draft', 'pending', 'publish' ], $values->toArray());
    }
    
    /** @test */
    public function it_returns_all_the_const_name_in_collection()
    {
        $keys = PostStatusEnumStub::keys();
        
        $this->assertInstanceOf(Collection::class, $keys);
        $this->assertArraySubset([ 'DRAFT', 'PENDING', 'PUBLISH' ], $keys->toArray());
    }
}
