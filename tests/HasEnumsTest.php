<?php

namespace Nevoss\Enumeration\Test;

use Nevoss\Enumeration\Exceptions\InvalidValueException;
use Nevoss\Enumeration\Test\Stubs\PostStatusEnumStub;
use Nevoss\Enumeration\Test\Stubs\PostStub;

class HasEnumsTest extends TestCase
{
    /**
     * @var PostStub
     */
    protected $postStub;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->postStub = PostStub::make([
            'title' => 'example',
            'status' => PostStatusEnumStub::DRAFT,
        ]);
    }
    
    /** @test */
    public function its_returns_the_Enum_class_when_ask_for_enum_key()
    {
        $this->assertInstanceOf(PostStatusEnumStub::class, $this->postStub->getAttribute('status'));
    }
    
    /** @test */
    public function it_returns_the_regular_attribute_if_the_attribute_is_not_in_the_enums_array()
    {
        $this->assertEquals('example', $this->postStub->getAttribute('title'));
    }
    
    /** @test */
    public function valid_enum_value_can_be_set()
    {
        $this->postStub->setAttribute('status', PostStatusEnumStub::PUBLISH);
        
        $this->assertEquals(new PostStatusEnumStub(PostStatusEnumStub::PUBLISH), $this->postStub->status);
    
        $this->postStub->setAttribute('status', new PostStatusEnumStub(PostStatusEnumStub::PENDING));
        
        $this->assertEquals(new PostStatusEnumStub(PostStatusEnumStub::PENDING), $this->postStub->status);
    }
    
    /** @test */
    public function regular_value_can_be_set()
    {
        $this->postStub->setAttribute('title', 'aaa');
        
        $this->assertEquals('aaa', $this->postStub->title);
    }
    
    /** @test */
    public function it_throw_exception_if_trying_to_set_invalid_value()
    {
        $this->expectException(InvalidValueException::class);
        
        $this->postStub->setAttribute('status', 'asdasdasdads');
    }
}
