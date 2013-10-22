<?php
namespace Yjv\TypeFactory;

interface TypeResolverInterface
{
    public function resolveTypeChain($type);
    public function resolveType($type);
    public function getTypeRegistry();
}
