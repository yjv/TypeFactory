<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 4/27/14
 * Time: 7:28 PM
 */

namespace Yjv\TypeFactory\Tests;


use Faker\Factory;
use Mockery;
use Yjv\TypeFactory\AbstractNamedBuilder;
use Yjv\TypeFactory\Tests\Fixtures\MockNamedBuilder;

class AbstractNamedBuilderTest extends AbstractBuilderTest
{
    protected $name;

    public function setUp()
    {
        $this->factory = \Mockery::mock('Yjv\TypeFactory\NamedTypeFactoryInterface');
        $this->options = array('key' => 'value');
        $this->name = Factory::create()->word;
        $this->builder = new MockNamedBuilder($this->name, $this->factory, $this->options);
    }

    public function testGettersSetters()
    {
        parent::testGettersSetters();
        $this->assertEquals($this->name, $this->builder->getName());
    }

}
 