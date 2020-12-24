<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpFunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
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
    public function create(\ReflectionFunction $reflection, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $phpDocReturnType, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, $filename) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpFunctionReflection;
}
