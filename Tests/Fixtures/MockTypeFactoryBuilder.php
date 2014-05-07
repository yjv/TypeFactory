<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/5/14
 * Time: 7:59 PM
 */

namespace Yjv\TypeFactory\Tests\Fixtures;


use Yjv\TypeFactory\AbstractTypeFactoryBuilder;
use Yjv\TypeFactory\TypeFactoryInterface;

class MockTypeFactoryBuilder extends AbstractTypeFactoryBuilder
{
    protected $factory;
    protected $defaultExtensions;

    public function __construct(TypeFactoryInterface $factory = null, array $defaultExtensions = array())
    {
        $this->factory = $factory;
        $this->defaultExtensions = $defaultExtensions;
    }

    /**
     * @return \Yjv\TypeFactory\TypeFactoryInterface
     */
    protected function getFactoryInstance()
    {
        return $this->factory;
    }

    protected function getDefaultExtensions()
    {
        return $this->defaultExtensions;
    }
}