<?php
namespace Yjv\TypeFactory;

class OptionsResolverNotReturnedException extends \Exception
{
    public function __construct()
    {

        parent::__construct(
            'No options resolver was returned from any of the types');
    }
}
