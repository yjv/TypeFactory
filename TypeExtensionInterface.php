<?php
namespace Yjv\TypeFactory;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

interface TypeExtensionInterface
{
    public function getExtendedType();
    public function build(BuilderInterface $builder, array $options);
    public function setDefaultOptions(OptionsResolverInterface $resolver);
}
