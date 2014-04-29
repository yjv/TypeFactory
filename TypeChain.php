<?php
namespace Yjv\TypeFactory;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TypeChain implements \Iterator, TypeChainInterface
{
    protected $index = 0;
    protected $types = array();
    protected $iterationDirection = TypeChainInterface::ITERATION_DIRECTION_PARENT_FIRST;
    protected $exclusionStrategy = TypeChainInterface::EXCLUSION_STRATEGY_NONE;

    public function __construct(array $types)
    {
        if (empty($types)) {

            throw new \InvalidArgumentException('$types must have at least one type in it.');
        }

        $this->types = $types;
    }

    public function setIterationDirection($direction)
    {
        $this->iterationDirection = $direction;
        $this->rewind();
        return $this;
    }
    
    public function setExclusionStrategy($strategy)
    {
        $this->exclusionStrategy = $strategy;
        $this->rewind();
        return $this;
    }

    public function rewind()
    {
        $this->index = $this->iterationDirection == TypeChainInterface::ITERATION_DIRECTION_PARENT_FIRST ? 0 : (count($this->types) - 1);
        $this->validateCurrentForExclusionStrategy();
    }

    public function current()
    {
        return $this->types[$this->index];
    }

    public function key()
    {
        return $this->index;
    }

    public function next()
    {
        $this->iterationDirection  == TypeChainInterface::ITERATION_DIRECTION_PARENT_FIRST ? $this->index++ : $this->index--;
        $this->validateCurrentForExclusionStrategy();
    }

    public function valid()
    {
        return isset($this->types[$this->index]);
    }

    public function getStartingType()
    {
        $this
            ->setExclusionStrategy(TypeChainInterface::EXCLUSION_STRATEGY_TYPES)
            ->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_CHILD_FIRST)
        ;

        return $this->current();
    }

    public function getOptionsResolver()
    {
        $this
            ->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_CHILD_FIRST)
            ->setExclusionStrategy(TypeChainInterface::EXCLUSION_STRATEGY_TYPE_EXTENSIONS)
        ;

        $optionsResolver = null;

        foreach ($this as $type) {

            if ($optionsResolver = $type->getOptionsResolver()) {

                break;
            }
        }

        return $optionsResolver;
    }

    public function getOptions(OptionsResolverInterface $optionsResolver, array $options)
    {
        $this
            ->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_PARENT_FIRST)
            ->setExclusionStrategy(TypeChainInterface::EXCLUSION_STRATEGY_NONE)
        ;

        /** @var $type TypeInterface */
        foreach ($this as $type) {

            $type->setDefaultOptions($optionsResolver);
        }

        return $optionsResolver->resolve($options);
    }

    public function getBuilder(TypeFactoryInterface $factory, array $options)
    {
        $this
            ->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_CHILD_FIRST)
            ->setExclusionStrategy(TypeChainInterface::EXCLUSION_STRATEGY_TYPE_EXTENSIONS)
        ;

        $builder = null;

        /** @var $type TypeInterface */
        foreach ($this as $type) {

            if ($builder = $type->createBuilder($factory, $options)) {

                break;
            }
        }

        if ($builder) {

            $builder->setTypeChain($this);
        }

        return $builder;
    }

    public function build(BuilderInterface $builder, array $options)
    {
        $this
            ->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_PARENT_FIRST)
            ->setExclusionStrategy(TypeChainInterface::EXCLUSION_STRATEGY_NONE)
        ;

        /** @var $type TypeInterface */
        foreach ($this as $type) {

            $type->build($builder, $options);
        }

        return $builder;
    }

    public function finalize($object, array $options)
    {
        $this
            ->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_PARENT_FIRST)
            ->setExclusionStrategy(TypeChainInterface::EXCLUSION_STRATEGY_TYPE_EXTENSIONS)
        ;

        foreach ($this as $type) {

            if ($type instanceof FinalizingTypeInterface) {

                $type->finalize($object, $options);
            }
        }

        return $object;
    }

    protected function validateCurrentForExclusionStrategy()
    {
        if (!$this->valid()) {
            
            return;
        }
        
        if (
            ($this->exclusionStrategy == TypeChainInterface::EXCLUSION_STRATEGY_TYPES
            && $this->current() instanceof TypeInterface)
            || ($this->exclusionStrategy == TypeChainInterface::EXCLUSION_STRATEGY_TYPE_EXTENSIONS
            && $this->current() instanceof TypeExtensionInterface)
        ) {
            $this->next();
        }
    }
}

