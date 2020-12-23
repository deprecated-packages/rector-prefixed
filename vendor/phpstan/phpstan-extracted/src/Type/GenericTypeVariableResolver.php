<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

class GenericTypeVariableResolver
{
    public static function getType(\_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName $type, string $genericClassName, string $typeVariableName) : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $ancestor = $type->getAncestorWithClassName($genericClassName);
        if ($ancestor === null) {
            return null;
        }
        $classReflection = $ancestor->getClassReflection();
        if ($classReflection === null) {
            return null;
        }
        $templateTypeMap = $classReflection->getActiveTemplateTypeMap();
        return $templateTypeMap->getType($typeVariableName);
    }
}
