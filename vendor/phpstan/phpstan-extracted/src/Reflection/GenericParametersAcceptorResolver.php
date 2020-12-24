<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\Generic\ResolvedFunctionVariant;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class GenericParametersAcceptorResolver
{
    /**
     * Resolve template types
     *
     * @param \PHPStan\Type\Type[] $argTypes Unpacked arguments
     */
    public static function resolve(array $argTypes, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor
    {
        $typeMap = \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
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
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Generic\ResolvedFunctionVariant($parametersAcceptor, new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap(\array_merge($parametersAcceptor->getTemplateTypeMap()->map(static function (string $name, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : Type {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
        })->getTypes(), $typeMap->getTypes())));
    }
}
