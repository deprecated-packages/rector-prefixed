<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Generic\ResolvedFunctionVariant;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
class GenericParametersAcceptorResolver
{
    /**
     * Resolve template types
     *
     * @param \PHPStan\Type\Type[] $argTypes Unpacked arguments
     */
    public static function resolve(array $argTypes, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor
    {
        $typeMap = \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
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
        return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Generic\ResolvedFunctionVariant($parametersAcceptor, new \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap(\array_merge($parametersAcceptor->getTemplateTypeMap()->map(static function (string $name, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : Type {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
        })->getTypes(), $typeMap->getTypes())));
    }
}
