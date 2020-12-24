<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\StringCast;

use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty;
use function sprintf;
/**
 * @internal
 */
final class ReflectionPropertyStringCast
{
    public static function toString(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty $propertyReflection) : string
    {
        $stateModifier = '';
        if (!$propertyReflection->isStatic()) {
            $stateModifier = $propertyReflection->isDefault() ? ' <default>' : ' <dynamic>';
        }
        return \sprintf('Property [%s %s%s $%s ]', $stateModifier, self::visibilityToString($propertyReflection), $propertyReflection->isStatic() ? ' static' : '', $propertyReflection->getName());
    }
    private static function visibilityToString(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty $propertyReflection) : string
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
