<?php

declare (strict_types=1);
namespace PHPStan\Type;

class GenericTypeVariableResolver
{
    public static function getType(\PHPStan\Type\TypeWithClassName $type, string $genericClassName, string $typeVariableName) : ?\PHPStan\Type\Type
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
