<?php
namespace Yjv\TypeFactory\Tests\Type\Extension;

use Yjv\TypeFactory\Type\Extension\DefaultOptionsTypeExtension;

use Mockery;

class DefaultOptionsTypeExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $typeExtension;
    protected $extendedType;
    protected $defaults;
    
    public function setUp()
    {
        $this->extendedType = 'dsfdfsdfs';
        $this->defaults = array('key' => 'value');
        $this->typeExtension = new DefaultOptionsTypeExtension($this->extendedType, $this->defaults);
    }
    
    public function testGetExtendedType()
    {
        $this->assertEquals($this->extendedType, $this->typeExtension->getExtendedType());
    }
    
    public function testSetDefaultOptions()
    {
        $resolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
            ->shouldReceive('setDefaults')
            ->once()
            ->with($this->defaults)
            ->getMock()
        ;
        $this->typeExtension->setDefaultOptions($resolver);
    }
}
