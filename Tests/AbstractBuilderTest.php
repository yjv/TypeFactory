<?php
namespace Yjv\TypeFactory\Tests;

use Mockery;
use Yjv\TypeFactory\AbstractBuilder;
use Yjv\TypeFactory\Tests\Fixtures\MockBuilder;

class AbstractBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var  AbstractBuilder */
    protected $builder;
    protected $factory;
    protected $options;
    
    public function setUp()
    {
        $this->factory = Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface');
        $this->options = array('key' => 'value');
        $this->builder = new MockBuilder($this->factory, $this->options);
    }
    
    public function testGettersSetters()
    {
        $this->assertEquals($this->options, $this->builder->getOptions());
        $this->assertSame($this->builder, $this->builder->setOption('key2', 'value2'));
        $this->assertEquals(array('key' => 'value', 'key2' => 'value2'), $this->builder->getOptions());
        $this->assertEquals('value2', $this->builder->getOption('key2'));
        $this->assertNull($this->builder->getOption('key3'));
        $this->assertEquals('default', $this->builder->getOption('key3', 'default'));
        $this->assertSame($this->builder, $this->builder->setOptions(array('key3' => 'value3')));
        $this->assertEquals(array('key3' => 'value3'), $this->builder->getOptions());
        $this->assertSame($this->factory, $this->builder->getFactory());
        $typeChain = Mockery::mock('Yjv\TypeFactory\TypeChainInterface');
        $this->assertNull($this->builder->getTypeChain());
        $this->assertSame($this->builder, $this->builder->setTypeChain($typeChain));
        $this->assertSame($typeChain, $this->builder->getTypeChain());
    }
}


