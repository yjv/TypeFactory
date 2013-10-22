<?php
namespace Yjv\TypeFactory\Extension;

use Yjv\TypeFactory\AbstractExtension;

class PreloadedExtension extends AbstractExtension
{
    protected $passedTypes;
    protected $passedTypeExtensions;
    
    public function __construct(array $types, array $typeExtensions)
    {
        $this->passedTypes = $types;
        $this->passedTypeExtensions = $typeExtensions;
    }
    
    protected function loadTypes()
    {
        return $this->passedTypes;
    }
    
    protected function loadTypeExtensions()
    {
        return $this->passedTypeExtensions;
    }
}
