<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 4/27/14
 * Time: 7:21 PM
 */

namespace Yjv\TypeFactory;


use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NamedTypeFactory extends TypeFactory implements NamedTypeFactoryInterface
{
    /**
     *
     * @param $name
     * @param string|TypeInterface $type
     * @param array $options
     * @return mixed the result of all the types and the builder
     */
    public function createNamed($name, $type, array $options = array())
    {
        $options['name'] = $name;
        return $this->create($type, $options);
    }

    /**
     *
     * @param $name
     * @param string|TypeInterface $type
     * @param array $options
     * @return BuilderInterface
     */
    public function createNamedBuilder($name, $type, array $options = array())
    {
        $options['name'] = $name;
        return $this->createBuilder($type, $options);
    }

    protected function getBuilder(TypeChainInterface $typeChain, array $options)
    {
        $builder = parent::getBuilder($typeChain, $options);

        if (!$builder instanceof NamedBuilderInterface) {

            throw new BuilderNotSupportedException($builder, 'Yjv\TypeFactory\NamedBuilderInterface');
        }

        return $builder;
    }

    protected function getOptions(
        TypeChainInterface $typeChain,
        OptionsResolverInterface $optionsResolver,
        array $options
    ) {
        $optionsResolver->setDefaults(array(
            'name' => $typeChain->getStartingType()->getName()
        ));

        return parent::getOptions(
            $typeChain,
            $optionsResolver,
            $options
        );
    }
} 