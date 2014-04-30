<?php
namespace Yjv\TypeFactory\Tests;
use Yjv\TypeFactory\TypeResolverInterface;

use Yjv\TypeFactory\TypeRegistryInterface;

use Yjv\TypeFactory\TypeFactory;

use Yjv\TypeFactory\TypeFactoryInterface;

use Yjv\TypeFactory\TypeRegistry;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Mockery;

class TypeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var  TypeFactory */
    protected $factory;
    /** @var Mockery\MockInterface */
    protected $resolver;
    /** @var Mockery\MockInterface */
    protected $builder;
    /** @var Mockery\MockInterface */
    protected $typeChain;
    /** @var Mockery\MockInterface */
    protected $optionsResolver;

    protected function setUp()
    {
        $this->optionsResolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolver');
        $this->typeChain = Mockery::mock('Yjv\TypeFactory\TypeChainInterface')
            ->shouldReceive('getOptionsResolver')
            ->byDefault()
            ->andReturn($this->optionsResolver)
            ->getMock()
            ->shouldReceive('getOptions')
            ->byDefault()
            ->andReturn(array('key' => 'value'))
            ->getMock()
            ->shouldReceive('getBuilder')
            ->byDefault()
            ->andReturn($this->builder)
            ->getMock()
            ->shouldReceive('build')
            ->byDefault()
            ->getMock()
            ->shouldReceive('finalize')
            ->byDefault()
            ->getMock()
        ;
        $this->resolver = Mockery::mock('Yjv\TypeFactory\TypeResolverInterface')
            ->shouldReceive('resolveTypeChain')
            ->byDefault()
            ->andReturn($this->typeChain)
            ->getMock()
        ;
        $this->factory = new TypeFactory($this->resolver);
        $this->builder = Mockery::mock('Yjv\TypeFactory\BuilderInterface');
    }

    public function testCreate()
    {
        $object = new \stdClass();
        $this->setupSuccessfulCreateBuilderExpectations($passedOptions = array('option1' => '1'));

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
        $this->setupSuccessfulCreateBuilderExpectations($passedOptions = array('option1' => '1'));

        $this->assertSame(
            $this->builder,
            $this->factory->createBuilder('name1', $passedOptions)
        );
    }

    /**
     * @expectedException \Yjv\TypeFactory\BuilderNotSupportedException
     */
    public function testCreateBuilderWithBadBuilderClass()
    {
        $this->typeChain
            ->shouldReceive('getBuilder')
            ->once()
            ->andReturn(new \stdClass())
        ;
        $this->factory->createBuilder('name1');
    }

    /**
     * @expectedException \Yjv\TypeFactory\BuilderNotReturnedException
     */
    public function testCreateBuilderWithBuilderNotReturned()
    {
        $this->typeChain
            ->shouldReceive('getBuilder')
            ->once()
        ;

        $this->factory->createBuilder('name1');
    }

    /**
     * @expectedException \Yjv\TypeFactory\OptionsResolverNotReturnedException
     */
    public function testCreateBuilderWithOptionsResolverNotReturned()
    {
        $this->typeChain
            ->shouldReceive('getOptionsResolver')
            ->once()
        ;

        $this->factory->createBuilder('name1');
    }

    public function testGetTypeChain()
    {
        $this->resolver
            ->shouldReceive('resolveTypeChain')
            ->with('type')
            ->once()
            ->andReturn($this->typeChain)
        ;

        $this->assertSame($this->typeChain, $this->factory->getTypeChain('type'));
    }

    public function testGetTypeRegistry()
    {
        $registry = Mockery::mock('Yjv\TypeFactory\TypeRegistryInterface');
        $this->resolver->shouldReceive('getTypeRegistry')->once()->andReturn($registry);
        $this->assertSame($registry, $this->factory->getTypeRegistry());
    }
    
    public function testGetBuilderInterfaceName()
    {
        $this->assertEquals(
            'Yjv\TypeFactory\BuilderInterface',
            $this->factory->getBuilderInterfaceName()
        );
    }

    protected function setupSuccessfulCreateBuilderExpectations(array $passedOptions)
    {
        $returnedOptions = array('option1' => '1', 'option2' => '2');
        $this->typeChain
            ->shouldReceive('getOptionsResolver')
            ->once()
            ->ordered()
            ->andReturn($this->optionsResolver)
            ->getMock()
            ->shouldReceive('getOptions')
            ->with($this->optionsResolver, $passedOptions)
            ->once()
            ->ordered()
            ->andReturn($returnedOptions)
            ->getMock()
            ->shouldReceive('getBuilder')
            ->once()
            ->with($this->factory, $returnedOptions)
            ->ordered()
            ->andReturn($this->builder)
            ->getMock()
            ->shouldReceive('build')
            ->with($this->builder, $returnedOptions)
            ->ordered()
            ->once()
            ->getMock()
        ;

        $this->resolver
            ->shouldReceive('resolveTypeChain')
            ->with('name1')
            ->andReturn($this->typeChain)
        ;
    }
}
