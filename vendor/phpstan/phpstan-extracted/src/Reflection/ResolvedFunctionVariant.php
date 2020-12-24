<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\Reflection\Php\DummyParameter;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeHelper;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class ResolvedFunctionVariant implements \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor
{
    /** @var ParametersAcceptor */
    private $parametersAcceptor;
    /** @var TemplateTypeMap */
    private $resolvedTemplateTypeMap;
    /** @var ParameterReflection[]|null */
    private $parameters = null;
    /** @var Type|null */
    private $returnType = null;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap)
    {
        $this->parametersAcceptor = $parametersAcceptor;
        $this->resolvedTemplateTypeMap = $resolvedTemplateTypeMap;
    }
    public function getTemplateTypeMap() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        return $this->parametersAcceptor->getTemplateTypeMap();
    }
    public function getResolvedTemplateTypeMap() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        return $this->resolvedTemplateTypeMap;
    }
    public function getParameters() : array
    {
        $parameters = $this->parameters;
        if ($parameters === null) {
            $parameters = \array_map(function (\_PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflection $param) : ParameterReflection {
                return new \_PhpScopere8e811afab72\PHPStan\Reflection\Php\DummyParameter($param->getName(), \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($param->getType(), $this->resolvedTemplateTypeMap), $param->isOptional(), $param->passedByReference(), $param->isVariadic(), $param->getDefaultValue());
            }, $this->parametersAcceptor->getParameters());
            $this->parameters = $parameters;
        }
        return $parameters;
    }
    public function isVariadic() : bool
    {
        return $this->parametersAcceptor->isVariadic();
    }
    public function getReturnType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->returnType;
        if ($type === null) {
            $type = \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($this->parametersAcceptor->getReturnType(), $this->resolvedTemplateTypeMap);
            $this->returnType = $type;
        }
        return $type;
    }
}
