<?php
namespace Yjv\TypeFactory;

use Yjv\TypeFactory\TypeResolverInterface;

use Yjv\TypeFactory\TypeRegistryInterface;

interface TypeFactoryBuilderInterface
{
    public function setExtensions(array $extension);
    public function addExtension(RegistryExtensionInterface $extension);
    public function getExtensions();
    public function addDefaultExtensions();
    public function setTypeRegistry(TypeRegistryInterface $typeRegistry);
    public function getTypeRegistry();
    public function setTypeResolver(TypeResolverInterface $typeResolver);
    public function getTypeResolver();
    public function setTypeName($typeName);
    public function getTypeName();
    public function setBuilderInterfaceName($builderInterfaceName);
    public function getBuilderInterfaceName();
    public function build();
}
