<?php
namespace Yjv\TypeFactory;

interface TypeRegistryInterface extends RegistryExtensionInterface
{
    public function addExtension(RegistryExtensionInterface $extension);
}
