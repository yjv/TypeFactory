<?php
namespace Yjv\TypeFactory\Tests;
use Faker\Factory;
use Yjv\TypeFactory\TypeFactoryBuilder;

use Yjv\TypeFactory\Tests\Fixtures\MockTypeFactoryBuilder;
use Yjv\TypeFactory\TypeResolver;
use Yjv\TypeFactory\TypeResolverInterface;

use Yjv\TypeFactory\TypeRegistryInterface;

use Yjv\TypeFactory\TypeFactory;

use Yjv\TypeFactory\TypeFactoryInterface;

use Yjv\TypeFactory\TypeRegistry;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Mockery;

class TypeFactoryBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockTypeFactoryBuilder  */
    protected $builder;
    /** @var  Mockery\MockInterface */
    protected $factory;
    protected $extension1;
    protected $extension2;

    public function setUp()
    {
        $this->factory = Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface');
        $this->extension1 = Mockery::mock('Yjv\TypeFactory\RegistryExtensionInterface');
        $this->extension2 = Mockery::mock('Yjv\TypeFactory\RegistryExtensionInterface');
        $this->builder = new TypeFactoryBuilder();
    }
    
    public function testBuild()
    {
        $registry = new TypeRegistry();
        $factory = new TypeFactory(new TypeResolver($registry));
        $registry
            ->addExtension($this->extension1)
            ->addExtension($this->extension2)
        ;
        $this->builder->addExtension($this->extension1);
        $this->builder->addExtension($this->extension2);
        $this->assertEquals($factory, $this->builder->build());
    }

    public function testBuildWithoutSettingExtensions()
    {
        $this->builder = new MockTypeFactoryBuilder(array($this->extension1, $this->extension2));
        $registry = new TypeRegistry();
        $factory = new TypeFactory(new TypeResolver($registry));
        $registry
            ->addExtension($this->extension1)
            ->addExtension($this->extension2)
        ;
        $this->assertEquals($factory, $this->builder->build());
    }

    public function testGettersSetters()
    {
        $this->assertEquals(TypeFactoryInterface::DEFAULT_BUILDER_INTERFACE_NAME, $this->builder->getBuilderInterfaceName());
        $builderInterfaceName = Factory::create()->word;
        $this->assertSame($this->builder, $this->builder->setBuilderInterfaceName($builderInterfaceName));
        $this->assertEquals($builderInterfaceName, $this->builder->getBuilderInterfaceName());
        $this->assertSame(array(), $this->builder->getExtensions());
        $this->builder = new MockTypeFactoryBuilder(array($this->extension1, $this->extension2));
        $this->assertSame(array($this->extension1, $this->extension2), $this->builder->getExtensions());
        $extension3 = Mockery::mock('Yjv\TypeFactory\RegistryExtensionInterface');
        $this->assertSame($this->builder, $this->builder->addExtension($extension3));
        $this->assertSame(array($this->extension1, $this->extension2, $extension3), $this->builder->getExtensions());
        $this->assertSame($this->builder, $this->builder->setExtensions(array($this->extension1, $extension3)));
        $this->assertSame(array($this->extension1, $extension3), $this->builder->getExtensions());
        $this->assertInstanceOf('Yjv\TypeFactory\TypeRegistryInterface', $this->builder->getTypeRegistry());
        $registry = Mockery::mock('Yjv\TypeFactory\TypeRegistryInterface');
        $this->assertSame($this->builder, $this->builder->setTypeRegistry($registry));
        $this->assertSame($registry, $this->builder->getTypeRegistry());
        $this->assertInstanceOf('Yjv\TypeFactory\TypeResolverInterface', $this->builder->getTypeResolver());
        $resolver = Mockery::mock('Yjv\TypeFactory\TypeResolverInterface');
        $this->assertSame($this->builder, $this->builder->setTypeResolver($resolver));
        $this->assertSame($resolver, $this->builder->getTypeResolver());
        $this->assertNull($this->builder->getTypeName());
        $name = 'name';
        $this->assertSame($this->builder, $this->builder->setTypeName($name));
        $this->assertEquals($name, $this->builder->getTypeName());
        $this->assertInstanceOf(get_class($this->builder), call_user_func(array(get_class($this->builder), 'create')));
    }
}
