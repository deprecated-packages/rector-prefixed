<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Type;
class FunctionVariantWithPhpDocs extends \PHPStan\Reflection\FunctionVariant implements \PHPStan\Reflection\ParametersAcceptorWithPhpDocs
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
    public function __construct(\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, ?\PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap, array $parameters, bool $isVariadic, \PHPStan\Type\Type $returnType, \PHPStan\Type\Type $phpDocReturnType, \PHPStan\Type\Type $nativeReturnType)
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
    public function getPhpDocReturnType() : \PHPStan\Type\Type
    {
        return $this->phpDocReturnType;
    }
    public function getNativeReturnType() : \PHPStan\Type\Type
    {
        return $this->nativeReturnType;
    }
}
