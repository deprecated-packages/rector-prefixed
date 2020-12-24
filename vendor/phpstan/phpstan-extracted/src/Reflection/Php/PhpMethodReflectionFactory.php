<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\Php;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
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
    public function create(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $declaringClass, ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $declaringTrait, \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, ?string $stubPhpDocString) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpMethodReflection;
}
