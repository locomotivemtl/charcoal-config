<?php

namespace Charcoal\Tests\Entity;

use ArrayAccess;

// From 'charcoal-config'
use Charcoal\Tests\ArrayAccessTrait;
use Charcoal\Tests\Entity\AbstractEntityTest;
use Charcoal\Tests\Entity\Mock\MacroEntity;
use Charcoal\Config\AbstractEntity;

/**
 * Test ArrayAccess implementation in AbstractEntity
 *
 * @coversDefaultClass \Charcoal\Config\AbstractEntity
 */
class EntityArrayAccessTest extends AbstractEntityTest
{
    use ArrayAccessTrait;

    /**
     * @var MacroEntity
     */
    public $obj;

    /**
     * Create a concrete MacroEntity instance.
     *
     * @return void
     */
    public function setUp()
    {
        $this->obj = $this->createEntity([
            'name' => 'Charcoal',
            'foo'  => 10,
        ]);
    }

    /**
     * Asserts that the object implements ArrayAccess.
     *
     * @coversNothing
     * @return MacroEntity
     */
    public function testArrayAccess()
    {
        $this->assertInstanceOf(ArrayAccess::class, $this->obj);
        return $this->obj;
    }



    // Test ArrayAccess on non-private properties
    // =========================================================================

    /**
     * @covers ::offsetExists()
     * @return void
     */
    public function testOffsetExists()
    {
        $obj = $this->obj;

        $this->assertObjectHasAttribute('name', $obj);
        $this->assertTrue(isset($obj['name']));
    }

    /**
     * @covers ::offsetGet()
     * @return void
     */
    public function testOffsetGet()
    {
        $obj = $this->obj;

        $this->assertAttributeEquals('Charcoal', 'name', $obj);
        $this->assertEquals('Charcoal', $obj['name']);
    }

    /**
     * @covers ::offsetSet()
     * @return void
     */
    public function testOffsetSet()
    {
        $obj = $this->obj;

        $obj['baz'] = 'waldo';
        $this->assertObjectHasAttribute('baz', $obj);
        $this->assertAttributeEquals('waldo', 'baz', $obj);
        $this->assertEquals('waldo', $obj['baz']);
    }

    /**
     * @covers ::offsetUnset()
     * @return void
     */
    public function testOffsetUnset()
    {
        $obj = $this->obj;

        unset($obj['name']);
        $this->assertObjectHasAttribute('name', $obj);
        $this->assertAttributeEmpty('name', $obj);
        $this->assertNull($obj['name']);
    }



    // Test ArrayAccess on encapsulated properties
    // =========================================================================

    /**
     * @covers \Charcoal\Tests\Entity\Mock\MacroEntity::foo()
     * @covers ::offsetExists()
     * @return void
     */
    public function testOffsetExistsOnEncapsulatedMethod()
    {
        $obj = $this->obj;

        $this->assertObjectHasAttribute('foo', $obj);
        $this->assertTrue(isset($obj['foo']));
    }

    /**
     * @covers \Charcoal\Tests\Entity\Mock\MacroEntity::foo()
     * @covers ::offsetGet()
     * @return void
     */
    public function testOffsetGetOnEncapsulatedMethod()
    {
        $obj = $this->obj;

        $this->assertAttributeEquals(20, 'foo', $obj);
        $this->assertEquals('foo is 20', $obj['foo']);
    }

    /**
     * @covers \Charcoal\Tests\Entity\Mock\MacroEntity::setFoo()
     * @covers ::offsetSet()
     * @return void
     */
    public function testOffsetSetOnEncapsulatedMethod()
    {
        $obj = $this->obj;

        $obj['foo'] = 32;
        $this->assertAttributeEquals(42, 'foo', $obj);
        $this->assertEquals('foo is 42', $obj['foo']);
    }

    /**
     * @covers \Charcoal\Tests\Entity\Mock\MacroEntity::setFoo()
     * @covers ::offsetUnset()
     * @return void
     */
    public function testOffsetUnsetOnEncapsulatedMethod()
    {
        $obj = $this->obj;

        unset($obj['foo']);
        $this->assertObjectHasAttribute('foo', $obj);
        $this->assertAttributeEquals(10, 'foo', $obj);
        $this->assertEquals('foo is 10', $obj['foo']);
    }



    // Test ArrayAccess via aliases
    // =========================================================================

    /**
     * @covers ::has()
     * @return void
     */
    public function testHas()
    {
        $obj = $this->obj;

        $this->assertObjectHasAttribute('name', $obj);
        $this->assertTrue($obj->has('name'));

        unset($obj['name']);
        $this->assertFalse($obj->has('name'));
    }

    /**
     * @covers ::get()
     * @return void
     */
    public function testGet()
    {
        $obj = $this->obj;

        $this->assertAttributeEquals('Charcoal', 'name', $obj);
        $this->assertEquals('Charcoal', $obj->get('name'));
    }

    /**
     * @covers ::set()
     * @return void
     */
    public function testSet()
    {
        $obj = $this->obj;

        $that = $obj->set('baz', 'waldo');
        $this->assertEquals($obj, $that);
        $this->assertObjectHasAttribute('baz', $obj);
        $this->assertAttributeEquals('waldo', 'baz', $obj);
        $this->assertEquals('waldo', $obj->get('baz'));
    }
}