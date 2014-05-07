<?php
namespace Yjv\TypeFactory;

class TypeFactoryBuilder implements TypeFactoryBuilderInterface
{
    protected $extensions = array();
    protected $typeRegistry;
    protected $typeResolver;
    protected $typeName;
    protected $builderInterfaceName;
    protected $extensionsSet = false;

    public static function create()
    {
        return new static();
    }

    public function setExtensions(array $extensions)
    {
        $this->extensions = $extensions;
        $this->extensionsSet = true;
        return $this;
    }

    public function addExtension(RegistryExtensionInterface $extension)
    {
        $this->extensions[] = $extension;
        $this->extensionsSet = true;
        return $this;
    }

    public function getExtensions()
    {
        if (!$this->extensionsSet) {

            $this->addDefaultExtensions();
        }

        return $this->extensions;
    }

    public function addDefaultExtensions()
    {
        foreach ($this->getDefaultExtensions() as $extension) {

            $this->addExtension($extension);
        }

        $this->extensionsSet = true;
        return $this;
    }

    public function setTypeRegistry(TypeRegistryInterface $typeRegistry)
    {
        $this->typeRegistry = $typeRegistry;
        return $this;
    }

    public function getTypeRegistry()
    {
        if (!$this->typeRegistry) {

            $this->typeRegistry = $this->getDefaultTypeRegistry();
        }

        return $this->typeRegistry;
    }

    public function setTypeResolver(TypeResolverInterface $typeResolver)
    {
        $this->typeResolver = $typeResolver;
        return $this;
    }

    public function getTypeResolver()
    {
        if (!$this->typeResolver) {

            $this->typeResolver = $this->getDefaultTypeResolver();
        }

        return $this->typeResolver;
    }

    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;
        return $this;
    }

    public function getTypeName()
    {
        return $this->typeName;
    }

    public function setBuilderInterfaceName($builderInterfaceName)
    {
        $this->builderInterfaceName = $builderInterfaceName;
        return $this;
    }

    public function getBuilderInterfaceName()
    {
        if (!$this->builderInterfaceName) {

            $this->builderInterfaceName = $this->getDefaultBuilderInterfaceName();
        }

        return $this->builderInterfaceName;
    }

    public function build()
    {
        $factory = $this->getFactoryInstance();
        $typeRegistry = $factory->getTypeRegistry();

        foreach ($this->getExtensions() as $extension) {

            $typeRegistry->addExtension($extension);
        }

        return $factory;
    }

    protected function getDefaultTypeRegistry()
    {
        return new TypeRegistry($this->getTypeName());
    }

    protected function getDefaultTypeResolver()
    {
        return new TypeResolver($this->getTypeRegistry());
    }

    protected function getDefaultBuilderInterfaceName()
    {
        return TypeFactoryInterface::DEFAULT_BUILDER_INTERFACE_NAME;
    }

    /**
     * @return array
     * @codeCoverageIgnore
     */
    protected function getDefaultExtensions()
    {
        return array();
    }

    /**
     * @return \Yjv\TypeFactory\TypeFactoryInterface
     */
    protected function getFactoryInstance()
    {
        return new TypeFactory(
            $this->getTypeResolver(),
            $this->getBuilderInterfaceName()
        );
    }
}
