<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\DummyParameter;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeHelper;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class ResolvedFunctionVariant implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor
{
    /** @var ParametersAcceptor */
    private $parametersAcceptor;
    /** @var TemplateTypeMap */
    private $resolvedTemplateTypeMap;
    /** @var ParameterReflection[]|null */
    private $parameters = null;
    /** @var Type|null */
    private $returnType = null;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap)
    {
        $this->parametersAcceptor = $parametersAcceptor;
        $this->resolvedTemplateTypeMap = $resolvedTemplateTypeMap;
    }
    public function getTemplateTypeMap() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap
    {
        return $this->parametersAcceptor->getTemplateTypeMap();
    }
    public function getResolvedTemplateTypeMap() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap
    {
        return $this->resolvedTemplateTypeMap;
    }
    public function getParameters() : array
    {
        $parameters = $this->parameters;
        if ($parameters === null) {
            $parameters = \array_map(function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParameterReflection $param) : ParameterReflection {
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\DummyParameter($param->getName(), \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($param->getType(), $this->resolvedTemplateTypeMap), $param->isOptional(), $param->passedByReference(), $param->isVariadic(), $param->getDefaultValue());
            }, $this->parametersAcceptor->getParameters());
            $this->parameters = $parameters;
        }
        return $parameters;
    }
    public function isVariadic() : bool
    {
        return $this->parametersAcceptor->isVariadic();
    }
    public function getReturnType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $type = $this->returnType;
        if ($type === null) {
            $type = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($this->parametersAcceptor->getReturnType(), $this->resolvedTemplateTypeMap);
            $this->returnType = $type;
        }
        return $type;
    }
}
