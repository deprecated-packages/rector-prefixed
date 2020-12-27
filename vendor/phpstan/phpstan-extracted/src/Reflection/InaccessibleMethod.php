<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
class InaccessibleMethod implements \PHPStan\Reflection\ParametersAcceptor
{
    /** @var MethodReflection */
    private $methodReflection;
    public function __construct(\PHPStan\Reflection\MethodReflection $methodReflection)
    {
        $this->methodReflection = $methodReflection;
    }
    public function getMethod() : \PHPStan\Reflection\MethodReflection
    {
        return $this->methodReflection;
    }
    public function getTemplateTypeMap() : \PHPStan\Type\Generic\TemplateTypeMap
    {
        return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getResolvedTemplateTypeMap() : \PHPStan\Type\Generic\TemplateTypeMap
    {
        return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflection>
     */
    public function getParameters() : array
    {
        return [];
    }
    public function isVariadic() : bool
    {
        return \true;
    }
    public function getReturnType() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\MixedType();
    }
}
