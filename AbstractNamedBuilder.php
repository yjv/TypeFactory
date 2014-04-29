<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 4/27/14
 * Time: 7:24 PM
 */

namespace Yjv\TypeFactory;


abstract class AbstractNamedBuilder extends AbstractBuilder implements NamedBuilderInterface
{
    protected $name;

    public function __construct(
        $name,
        NamedTypeFactoryInterface $factory,
        array $options = array()
    ) {
        $this->name = $name;
        parent::__construct($factory, $options);
    }

    public function getName()
    {
        return $this->name;
    }
} 