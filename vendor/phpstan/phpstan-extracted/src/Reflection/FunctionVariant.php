<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection;

use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
class FunctionVariant implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptor
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
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap, array $parameters, bool $isVariadic, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $returnType)
    {
        $this->templateTypeMap = $templateTypeMap;
        $this->resolvedTemplateTypeMap = $resolvedTemplateTypeMap;
        $this->parameters = $parameters;
        $this->isVariadic = $isVariadic;
        $this->returnType = $returnType;
    }
    public function getTemplateTypeMap() : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap
    {
        return $this->templateTypeMap;
    }
    public function getResolvedTemplateTypeMap() : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap
    {
        return $this->resolvedTemplateTypeMap ?? \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
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
    public function getReturnType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->returnType;
    }
}
