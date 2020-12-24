<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

class GenericTypeVariableResolver
{
    public static function getType(\_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName $type, string $genericClassName, string $typeVariableName) : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
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
