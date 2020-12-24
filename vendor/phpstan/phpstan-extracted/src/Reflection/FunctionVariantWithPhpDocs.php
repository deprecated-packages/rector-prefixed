<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class FunctionVariantWithPhpDocs extends \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariant implements \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorWithPhpDocs
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
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, ?\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap, array $parameters, bool $isVariadic, \_PhpScopere8e811afab72\PHPStan\Type\Type $returnType, \_PhpScopere8e811afab72\PHPStan\Type\Type $phpDocReturnType, \_PhpScopere8e811afab72\PHPStan\Type\Type $nativeReturnType)
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
    public function getPhpDocReturnType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->phpDocReturnType;
    }
    public function getNativeReturnType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->nativeReturnType;
    }
}
