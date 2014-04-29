<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 4/27/14
 * Time: 7:23 PM
 */

namespace Yjv\TypeFactory;


interface NamedBuilderInterface extends BuilderInterface
{
    public function getName();
} 