<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Type;
class FunctionVariant implements \PHPStan\Reflection\ParametersAcceptor
{
    /** @var TemplateTypeMap */
    private $templateTypeMap;
    /** @var TemplateTypeMap|null */
    private $resolvedTemplateTypeMap;
    /** @var array<int, ParameterReflection> */
    private $parameters;
    /** @var bool */
    private $isVariadic;
    /** @var Type */
    private $returnType;
    /**
     * @param array<int, ParameterReflection> $parameters
     * @param bool $isVariadic
     * @param Type $returnType
     */
    public function __construct(\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, ?\PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap, array $parameters, bool $isVariadic, \PHPStan\Type\Type $returnType)
    {
        $this->templateTypeMap = $templateTypeMap;
        $this->resolvedTemplateTypeMap = $resolvedTemplateTypeMap;
        $this->parameters = $parameters;
        $this->isVariadic = $isVariadic;
        $this->returnType = $returnType;
    }
    public function getTemplateTypeMap() : \PHPStan\Type\Generic\TemplateTypeMap
    {
        return $this->templateTypeMap;
    }
    public function getResolvedTemplateTypeMap() : \PHPStan\Type\Generic\TemplateTypeMap
    {
        return $this->resolvedTemplateTypeMap ?? \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    /**
     * @return array<int, ParameterReflection>
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }
    public function isVariadic() : bool
    {
        return $this->isVariadic;
    }
    public function getReturnType() : \PHPStan\Type\Type
    {
        return $this->returnType;
    }
}
