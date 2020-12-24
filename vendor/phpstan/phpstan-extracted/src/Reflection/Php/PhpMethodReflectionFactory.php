<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Php;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface PhpMethodReflectionFactory
{
    /**
     * @param \PHPStan\Reflection\ClassReflection $declaringClass
     * @param \PHPStan\Reflection\ClassReflection|null $declaringTrait
     * @param BuiltinMethodReflection $reflection
     * @param TemplateTypeMap $templateTypeMap
     * @param \PHPStan\Type\Type[] $phpDocParameterTypes
     * @param \PHPStan\Type\Type|null $phpDocReturnType
     * @param \PHPStan\Type\Type|null $phpDocThrowType
     * @param string|null $deprecatedDescription
     * @param bool $isDeprecated
     * @param bool $isInternal
     * @param bool $isFinal
     * @param string|null $stubPhpDocString
     *
     * @return \PHPStan\Reflection\Php\PhpMethodReflection
     */
    public function create(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $declaringClass, ?\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $declaringTrait, \_PhpScopere8e811afab72\PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, ?string $stubPhpDocString) : \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpMethodReflection;
}
