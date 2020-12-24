<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpFunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
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
    public function create(\ReflectionFunction $reflection, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, $filename) : \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpFunctionReflection;
}
