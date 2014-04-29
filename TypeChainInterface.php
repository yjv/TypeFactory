<?php
namespace Yjv\TypeFactory;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

interface TypeChainInterface extends \Traversable
{
    const ITERATION_DIRECTION_PARENT_FIRST = 'parent_first';
    const ITERATION_DIRECTION_CHILD_FIRST = 'child_first';
    const EXCLUSION_STRATEGY_NONE = 'exclude_none';
    const EXCLUSION_STRATEGY_TYPES = 'exclude_types';
    const EXCLUSION_STRATEGY_TYPE_EXTENSIONS = 'exclude_type_extensions';

    /**
     * @param $direction
     * @return $this
     */
    public function setIterationDirection($direction);

    /**
     * @param $strategy
     * @return $this
     */
    public function setExclusionStrategy($strategy);

    /**
     * @return OptionsResolverInterface|null
     */
    public function getOptionsResolver();

    /**
     * @param OptionsResolverInterface $optionsResolver
     * @param array $options
     * @return array
     */
    public function getOptions(OptionsResolverInterface $optionsResolver, array $options);

    /**
     * @param TypeFactoryInterface $factory
     * @param array $options
     * @return BuilderInterface
     */
    public function getBuilder(TypeFactoryInterface $factory, array $options);

    /**
     * @param BuilderInterface $builder
     * @param array $options
     * @return object
     */
    public function build(BuilderInterface $builder, array $options);

    /**
     * @param $object
     * @param array $options
     * @return object
     */
    public function finalize($object, array $options);

    /**
     * @return TypeInterface|null
     */
    public function getStartingType();
}
