<?php
namespace Yjv\TypeFactory\Tests\Extension\Type;

use Yjv\TypeFactory\TypeResolver;

use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;

use Yjv\TypeFactory\TypeRegistry;

class TypeTestCase extends \PHPUnit_Framework_TestCase
{
	protected $builder;
    protected $mockedBuilder;
	protected $factory;
	protected $resolver;
	protected $registry;
	protected $type;
	
	protected function setUp()
	{
		$this->registry = new TypeRegistry();
		$this->resolver = new TypeResolver($this->registry);
		
		foreach ($this->getExtensions() as $extension) {
		    
    		$this->registry->addExtension($extension);
		}
	}
	
	protected function getExtensions()
	{
	    return array();
	}
}
