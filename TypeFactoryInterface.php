<?php
namespace Yjv\TypeFactory;

interface TypeFactoryInterface
{
    const DEFAULT_BUILDER_INTERFACE_NAME = 'Yjv\TypeFactory\BuilderInterface';

    /**
     *
     * @param string|TypeInterface $type
     * @param array $options
     * @return mixed the result of all the types and the builder
     */
    public function create($type, array $options = array());

    /**
     *
     * @param string|TypeInterface $type
     * @param array $options
     * @return BuilderInterface
     */
    public function createBuilder($type, array $options = array());
    
    /**
     * 
     * @param string|TypeInterface $type
     * @return TypeChainInterface
     */
    public function getTypeChain($type);
    
    /**
     * 
     * @return TypeRegistryInterface
     */
    public function getTypeRegistry();
    
    /**
     * @return string
     */
    public function getBuilderInterfaceName();
}
