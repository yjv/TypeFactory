<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/5/14
 * Time: 7:59 PM
 */

namespace Yjv\TypeFactory\Tests\Fixtures;


use Yjv\TypeFactory\TypeFactoryBuilder;
use Yjv\TypeFactory\TypeFactoryInterface;

class MockTypeFactoryBuilder extends TypeFactoryBuilder
{
    protected $factory;
    protected $defaultExtensions;

    public function __construct(array $defaultExtensions = array())
    {
        $this->defaultExtensions = $defaultExtensions;
    }

    protected function getDefaultExtensions()
    {
        return $this->defaultExtensions;
    }
}