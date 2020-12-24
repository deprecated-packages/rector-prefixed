<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Generic\ResolvedFunctionVariant;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class GenericParametersAcceptorResolver
{
    /**
     * Resolve template types
     *
     * @param \PHPStan\Type\Type[] $argTypes Unpacked arguments
     */
    public static function resolve(array $argTypes, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor
    {
        $typeMap = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
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
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Generic\ResolvedFunctionVariant($parametersAcceptor, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap(\array_merge($parametersAcceptor->getTemplateTypeMap()->map(static function (string $name, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : Type {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
        })->getTypes(), $typeMap->getTypes())));
    }
}
