<?php
namespace Yjv\TypeFactory;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeFactory implements TypeFactoryInterface
{
    protected $typeResolver;
    protected $builderInterfaceName;

    public function __construct(
        TypeResolverInterface $typeResolver,
        $builderInterfaceName = TypeFactoryInterface::DEFAULT_BUILDER_INTERFACE_NAME
    ) {
        $this->typeResolver = $typeResolver;
        $this->builderInterfaceName = $builderInterfaceName;
    }

    /**
     * {@inheritdoc}
     */
    public function create($type, array $options = array())
    {
        return $this->createBuilder($type, $options)->build();
    }

    /**
     * {@inheritdoc}
     */
    public function createBuilder($type, array $options = array())
    {
        $typeChain = $this->getTypeChain($type);
        $optionsResolver = $this->getOptionsResolver($typeChain);
        $options = $this->getOptions($typeChain, $optionsResolver, $options);
        $builder = $this->getBuilder($typeChain, $options);
        $this->build($typeChain, $builder, $options);

        return $builder;
    }

    public function getTypeChain($type)
    {
        return $this->typeResolver->resolveTypeChain($type);
    }

    public function getTypeRegistry()
    {
        return $this->typeResolver->getTypeRegistry();
    }
    
    /**
     * (non-PHPdoc)
     * @see \Yjv\TypeFactory\TypeFactoryInterface::getBuilderInterfaceName()
     * @codeCoverageIgnore
     */
    public function getBuilderInterfaceName()
    {
        return $this->builderInterfaceName;
    }

    protected function getOptionsResolver(TypeChainInterface $typeChain)
    {
        if (!$optionsResolver = $typeChain->getOptionsResolver()) {

            throw new OptionsResolverNotReturnedException();
        }

        return $optionsResolver;
    }

    protected function getOptions(
        TypeChainInterface $typeChain, 
        OptionsResolverInterface $optionsResolver, 
        array $options
    ) {
        return $typeChain->getOptions($optionsResolver, $options);
    }

    protected function getBuilder(TypeChainInterface $typeChain, array $options)
    {
        if (!$builder = $typeChain->getBuilder($this, $options)) {
            
            throw new BuilderNotReturnedException();
        }
        
        $requiredInterface = $this->getBuilderInterfaceName();
        
        if (!$builder instanceof $requiredInterface) {
        
            throw new BuilderNotSupportedException($builder, $requiredInterface);
        }
        
        return $builder;
    }

    protected function build(TypeChainInterface $typeChain, $builder, array $options)
    {
        $typeChain->build($builder, $options);
    }
}
