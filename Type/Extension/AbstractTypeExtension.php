<?php
namespace Yjv\TypeFactory\Type\Extension;

use Yjv\TypeFactory\BuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\TypeFactory\TypeExtensionInterface;

abstract class AbstractTypeExtension implements TypeExtensionInterface
{
    public function build(BuilderInterface $builder, array $options)
    {
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }
}

