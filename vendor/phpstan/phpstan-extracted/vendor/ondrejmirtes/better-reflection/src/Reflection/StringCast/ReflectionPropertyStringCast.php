<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\StringCast;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty;
use function sprintf;
/**
 * @internal
 */
final class ReflectionPropertyStringCast
{
    public static function toString(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty $propertyReflection) : string
    {
        $stateModifier = '';
        if (!$propertyReflection->isStatic()) {
            $stateModifier = $propertyReflection->isDefault() ? ' <default>' : ' <dynamic>';
        }
        return \sprintf('Property [%s %s%s $%s ]', $stateModifier, self::visibilityToString($propertyReflection), $propertyReflection->isStatic() ? ' static' : '', $propertyReflection->getName());
    }
    private static function visibilityToString(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty $propertyReflection) : string
    {
        if ($propertyReflection->isProtected()) {
            return 'protected';
        }
        if ($propertyReflection->isPrivate()) {
            return 'private';
        }
        return 'public';
    }
}
