<?php
namespace Yjv\TypeFactory;

use Yjv\TypeFactory\TypeResolverInterface;

use Yjv\TypeFactory\TypeRegistryInterface;

interface FactoryBuilderInterface
{
    public function addExtension(RegistryExtensionInterface $extension);
    public function setTypeRegistry(TypeRegistryInterface $typeRegistry);
    public function getTypeRegistry();
    public function setTypeResolver(TypeResolverInterface $typeResolver);
    public function getTypeResolver();
    public function setTypeName($typeName);
    public function getTypeName();
    public function build();
}
