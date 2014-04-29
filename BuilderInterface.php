<?php
namespace Yjv\TypeFactory;

interface BuilderInterface
{
    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function setOption($name, $value);

    /**
     * @param $name
     * @param null $default
     * @return mixed
     */
    public function getOption($name, $default = null);

    /**
     * @return array
     */
    public function getOptions();

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options);

    /**
     * @return TypeFactoryInterface
     */
    public function getFactory();

    /**
     * @param TypeChainInterface $typeChain
     * @return $this
     */
    public function setTypeChain(TypeChainInterface $typeChain);

    /**
     * @return TypeChainInterface
     */
    public function getTypeChain();

    /**
     * @return object
     */
    public function build();
}
