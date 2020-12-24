<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpFunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
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
    public function create(\ReflectionFunction $reflection, \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, $filename) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpFunctionReflection;
}
