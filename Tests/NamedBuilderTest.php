<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 4/27/14
 * Time: 7:28 PM
 */

namespace Yjv\TypeFactory\Tests;


use Yjv\TypeFactory\AbstractNamedBuilder;

class NamedBuilderTest extends BuilderTest
{
    public function setUp()
    {
        $this->factory = \Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface');
        $this->options = array('key' => 'value');
        $this->builder = new AbstractNamedBuilder($this->factory, $this->options);
    }

}
 