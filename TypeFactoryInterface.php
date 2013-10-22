<?php
namespace Yjv\TypeFactory;

interface TypeFactoryInterface
{
    /**
     * 
     * @param string|TypeInterface $type
     * @return mixed the result of all the types and the builder
     */
    public function create($type, array $options = array());
    
    /**
     * 
     * @param string|TypeInterface $type
     * @return Yjv\TypeFactory\BuilderInterface
     */
    public function createBuilder($type, array $options = array());
    
    /**
     * 
     * @param string|TypeInterface $type
     * @return Yjv\TypeFactory\TypeChainInterface
     */
    public function getTypeChain($type);
    
    /**
     * 
     * @return Yjv\TypeFactory\TypeRegistryInterface
     */
    public function getTypeRegistry();
    
    /**
     * @return string
     */
    public function getBuilderInterfaceName();
}
