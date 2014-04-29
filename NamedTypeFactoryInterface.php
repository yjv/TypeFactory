<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 4/27/14
 * Time: 6:55 PM
 */

namespace Yjv\TypeFactory;


interface NamedTypeFactoryInterface extends TypeFactoryInterface
{
    /**
     *
     * @param $name
     * @param string|TypeInterface $type
     * @param array $options
     * @return mixed the result of all the types and the builder
     */
    public function createNamed($name, $type, array $options = array());

    /**
     *
     * @param $name
     * @param string|TypeInterface $type
     * @param array $options
     * @return BuilderInterface
     */
    public function createNamedBuilder($name, $type, array $options = array());
} 