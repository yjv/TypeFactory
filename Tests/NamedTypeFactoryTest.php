<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 4/29/14
 * Time: 10:17 PM
 */

namespace Yjv\TypeFactory\Tests;


use Faker\Factory;
use Mockery;
use Yjv\TypeFactory\NamedTypeFactory;

class NamedTypeFactoryTest extends TypeFactoryTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->factory = new NamedTypeFactory($this->resolver);
        $this->builder = Mockery::mock('Yjv\TypeFactory\NamedBuilderInterface');
    }

    public function testCreate()
    {
        $object = new \stdClass();
        $this->setupSuccessfulCreateBuilderExpectations(
            $passedOptions = array('option1' => '1')
        );
        $this->builder
            ->shouldReceive('build')
            ->once()
            ->andReturn($object)
        ;

        $this->assertSame(
            $object,
            $this->factory->create('name1', $passedOptions)
        );
    }

    public function testCreateBuilder()
    {
        $this->setupSuccessfulCreateBuilderExpectations(
            $passedOptions = array('option1' => '1')
        );

        $this->assertSame(
            $this->builder,
            $this->factory->createBuilder('name1', $passedOptions)
        );
    }
    public function testCreateNamed()
    {
        $object = new \stdClass();
        $passedOptions = array('option1' => '1');
        $name = Factory::create()->word;
        $fullPassedOptions = $passedOptions;
        $fullPassedOptions['name'] = $name;
        $this->setupSuccessfulCreateBuilderExpectations(
            $fullPassedOptions
        );
        $this->builder
            ->shouldReceive('build')
            ->once()
            ->andReturn($object)
        ;

        $this->assertSame(
            $object,
            $this->factory->createNamed($name, 'name1', $passedOptions)
        );
    }

    public function testCreateNamedBuilder()
    {
        $passedOptions = array('option1' => '1');
        $name = Factory::create()->word;
        $fullPassedOptions = $passedOptions;
        $fullPassedOptions['name'] = $name;
        $this->setupSuccessfulCreateBuilderExpectations(
            $fullPassedOptions
        );

        $this->assertSame(
            $this->builder,
            $this->factory->createNamedBuilder($name, 'name1', $passedOptions)
        );
    }

    /**
     * @expectedException \Yjv\TypeFactory\BuilderNotSupportedException
     */
    public function testCreateBuilderWithBadBuilderClass()
    {
        $name = Factory::create()->word;
        $this->typeChain
            ->shouldReceive('getStartingType->getName')
            ->andReturn($name)
        ;
        $this->optionsResolver
            ->shouldReceive('setDefaults')
            ->once()
            ->with(array('name' => $name))
            ->getMock()
        ;
        parent::testCreateBuilderWithBadBuilderClass();
    }

    /**
     * @expectedException \Yjv\TypeFactory\BuilderNotSupportedException
     */
    public function testCreateBuilderWithBuilderClassNotNamedBuilderInterface()
    {
        $name = Factory::create()->word;
        $this->typeChain
            ->shouldReceive('getStartingType->getName')
            ->andReturn($name)
        ;
        $this->optionsResolver
            ->shouldReceive('setDefaults')
            ->once()
            ->with(array('name' => $name))
            ->getMock()
        ;
        $this->typeChain
            ->shouldReceive('getBuilder')
            ->once()
            ->andReturn(Mockery::mock('Yjv\TypeFactory\BuilderInterface'))
        ;
        $this->factory->createBuilder('name1');
    }

    /**
     * @expectedException \Yjv\TypeFactory\BuilderNotReturnedException
     */
    public function testCreateBuilderWithBuilderNotReturned()
    {
        $name = Factory::create()->word;
        $this->typeChain
            ->shouldReceive('getStartingType->getName')
            ->andReturn($name)
        ;
        $this->optionsResolver
            ->shouldReceive('setDefaults')
            ->once()
            ->with(array('name' => $name))
            ->getMock()
        ;
        parent::testCreateBuilderWithBuilderNotReturned();
    }

    protected function setupSuccessfulCreateBuilderExpectations(array $passedOptions)
    {
        $name = Factory::create()->word;
        $this->typeChain
            ->shouldReceive('getStartingType->getName')
            ->andReturn($name)
        ;
        $this->optionsResolver
            ->shouldReceive('setDefaults')
            ->once()
            ->with(array('name' => $name))
            ->getMock()
        ;
        parent::setupSuccessfulCreateBuilderExpectations($passedOptions);
    }
}
 