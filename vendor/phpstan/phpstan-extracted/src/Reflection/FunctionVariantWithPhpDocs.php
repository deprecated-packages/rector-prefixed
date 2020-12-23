<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection;

use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
class FunctionVariantWithPhpDocs extends \_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionVariant implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorWithPhpDocs
{
    /** @var Type */
    private $phpDocReturnType;
    /** @var Type */
    private $nativeReturnType;
    /**
     * @param TemplateTypeMap $templateTypeMap
     * @param array<int, \PHPStan\Reflection\ParameterReflectionWithPhpDocs> $parameters
     * @param bool $isVariadic
     * @param Type $returnType
     * @param Type $phpDocReturnType
     * @param Type $nativeReturnType
     */
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap, array $parameters, bool $isVariadic, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $returnType, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $phpDocReturnType, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $nativeReturnType)
    {
        parent::__construct($templateTypeMap, $resolvedTemplateTypeMap, $parameters, $isVariadic, $returnType);
        $this->phpDocReturnType = $phpDocReturnType;
        $this->nativeReturnType = $nativeReturnType;
    }
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflectionWithPhpDocs>
     */
    public function getParameters() : array
    {
        /** @var \PHPStan\Reflection\ParameterReflectionWithPhpDocs[] $parameters */
        $parameters = parent::getParameters();
        return $parameters;
    }
    public function getPhpDocReturnType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->phpDocReturnType;
    }
    public function getNativeReturnType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->nativeReturnType;
    }
}
