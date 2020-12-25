<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PHPStan\Reflection\Php\PhpFunctionReflection;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Type;
interface FunctionReflectionFactory
{
    /**
     * @param \ReflectionFunction $reflection
     * @param TemplateTypeMap $templateTypeMap
     * @param \PHPStan\Type\Type[] $phpDocParameterTypes
     * @param Type|null $phpDocReturnType
     * @param Type|null $phpDocThrowType
     * @param string|null $deprecatedDescription
     * @param bool $isDeprecated
     * @param bool $isInternal
     * @param bool $isFinal
     * @param string|false $filename
     * @return PhpFunctionReflection
     */
    public function create(\ReflectionFunction $reflection, \PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\PHPStan\Type\Type $phpDocReturnType, ?\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, $filename) : \PHPStan\Reflection\Php\PhpFunctionReflection;
}
