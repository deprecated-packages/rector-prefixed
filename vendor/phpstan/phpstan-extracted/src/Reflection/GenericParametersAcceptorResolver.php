<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\Reflection\Generic\ResolvedFunctionVariant;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class GenericParametersAcceptorResolver
{
    /**
     * Resolve template types
     *
     * @param \PHPStan\Type\Type[] $argTypes Unpacked arguments
     */
    public static function resolve(array $argTypes, \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor) : \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor
    {
        $typeMap = \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($parametersAcceptor->getParameters() as $i => $param) {
            if (isset($argTypes[$i])) {
                $argType = $argTypes[$i];
            } elseif ($param->getDefaultValue() !== null) {
                $argType = $param->getDefaultValue();
            } else {
                break;
            }
            $paramType = $param->getType();
            $typeMap = $typeMap->union($paramType->inferTemplateTypes($argType));
        }
        return new \_PhpScopere8e811afab72\PHPStan\Reflection\Generic\ResolvedFunctionVariant($parametersAcceptor, new \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap(\array_merge($parametersAcceptor->getTemplateTypeMap()->map(static function (string $name, \_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
        })->getTypes(), $typeMap->getTypes())));
    }
}
