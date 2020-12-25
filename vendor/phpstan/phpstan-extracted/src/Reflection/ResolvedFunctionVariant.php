<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PHPStan\Reflection\Php\DummyParameter;
use PHPStan\Type\Generic\TemplateTypeHelper;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Type;
class ResolvedFunctionVariant implements \PHPStan\Reflection\ParametersAcceptor
{
    /** @var ParametersAcceptor */
    private $parametersAcceptor;
    /** @var TemplateTypeMap */
    private $resolvedTemplateTypeMap;
    /** @var ParameterReflection[]|null */
    private $parameters = null;
    /** @var Type|null */
    private $returnType = null;
    public function __construct(\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor, \PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap)
    {
        $this->parametersAcceptor = $parametersAcceptor;
        $this->resolvedTemplateTypeMap = $resolvedTemplateTypeMap;
    }
    public function getTemplateTypeMap() : \PHPStan\Type\Generic\TemplateTypeMap
    {
        return $this->parametersAcceptor->getTemplateTypeMap();
    }
    public function getResolvedTemplateTypeMap() : \PHPStan\Type\Generic\TemplateTypeMap
    {
        return $this->resolvedTemplateTypeMap;
    }
    public function getParameters() : array
    {
        $parameters = $this->parameters;
        if ($parameters === null) {
            $parameters = \array_map(function (\PHPStan\Reflection\ParameterReflection $param) : ParameterReflection {
                return new \PHPStan\Reflection\Php\DummyParameter($param->getName(), \PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($param->getType(), $this->resolvedTemplateTypeMap), $param->isOptional(), $param->passedByReference(), $param->isVariadic(), $param->getDefaultValue());
            }, $this->parametersAcceptor->getParameters());
            $this->parameters = $parameters;
        }
        return $parameters;
    }
    public function isVariadic() : bool
    {
        return $this->parametersAcceptor->isVariadic();
    }
    public function getReturnType() : \PHPStan\Type\Type
    {
        $type = $this->returnType;
        if ($type === null) {
            $type = \PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($this->parametersAcceptor->getReturnType(), $this->resolvedTemplateTypeMap);
            $this->returnType = $type;
        }
        return $type;
    }
}
