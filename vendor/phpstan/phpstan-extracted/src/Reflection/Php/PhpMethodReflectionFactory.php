<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\Php;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
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
    public function create(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $declaringClass, ?\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $declaringTrait, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, ?string $stubPhpDocString) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\PhpMethodReflection;
}
