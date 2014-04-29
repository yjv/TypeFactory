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

    protected $factory;
    protected $finalizingFactory;
    protected $resolver;
    protected $builder;
    protected $typeChain;

    protected function setUp()
    {
        $this->typeChain = Mockery::mock('Yjv\TypeFactory\TypeChainInterface')
            ->shouldReceive('getOptionsResolver')
            ->byDefault()
            ->andReturn(Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolver'))
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
        $this->factory = new TestTypeFactory($this->resolver, 'Yjv\TypeFactory\BuilderInterface');
        $this->finalizingFactory = new TestTypeFactory(
            $this->resolver, 
            'Yjv\TypeFactory\BuilderInterface',
            true
        );
        $this->builder = Mockery::mock('Yjv\TypeFactory\BuilderInterface');
    }

    /**
     */
    public function testCreateBuilder()
    {
        $passedOptions = array('option1' => '1');
        $returnedOptions = array('option1' => '1', 'option2' => '2');
        $optionsResolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolver');
        $this->typeChain
            ->shouldReceive('getOptionsResolver')
            ->once()
            ->ordered()
            ->andReturn($optionsResolver)
            ->getMock()
            ->shouldReceive('getOptions')
            ->with($optionsResolver, $passedOptions)
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

        $this->assertSame(
            $this->builder,
            $this->factory->createBuilder('name1', $passedOptions)
        );
    }

    /**
     * @expectedException Yjv\TypeFactory\BuilderNotSupportedException
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
     * @expectedException Yjv\TypeFactory\BuilderNotReturnedException
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
     * @expectedException Yjv\TypeFactory\OptionsResolverNotReturnedException
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
}

class TestTypeFactory extends TypeFactory
{
    protected $builderClass;
    
    public function __construct(TypeResolverInterface $resolver, $builderClass = null, $supportsFinalizing = false)
    {
        $this->builderClass = $builderClass;
        parent::__construct($resolver, $supportsFinalizing);
    }
    
    /**
    * @return string
    */
    public function getBuilderInterfaceName() {

        if (!is_string($this->builderClass)) {
            
            return parent::getBuilderInterfaceName();
        }
        
        return $this->builderClass;
    }

    public function create($type, array $options = array())
    {
    }
}
