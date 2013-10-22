<?php
namespace Yjv\TypeFactory\Tests;

use Yjv\TypeFactory\TypeFactoryInterface;

use Yjv\TypeFactory\BuilderInterface;

use Yjv\TypeFactory\AbstractType;

use Mockery;

class AbstractTypeTest extends \PHPUnit_Framework_TestCase
{
    protected $type;
    
    public function setUp()
    {
        $this->type = new TestType();
    }
    
    public function testGetParent()
    {
        $this->assertFalse($this->type->getParent());
    }
    
    public function testSetDefaultOptions()
    {
        $this->type->setDefaultOptions(Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface'));
    }
    
    public function testGetOptionsResolver()
    {
        $this->assertInstanceOf('Symfony\Component\OptionsResolver\OptionsResolverInterface', $this->type->getOptionsResolver());
    }
}

class TestType extends AbstractType
{
    public function build(BuilderInterface $builder, array $options)
    {
    }

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
    }

    public function getName()
    {
        return 'test';
    }
}
