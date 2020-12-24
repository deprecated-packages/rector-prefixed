<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\StringCast;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty;
use function sprintf;
/**
 * @internal
 */
final class ReflectionPropertyStringCast
{
    public static function toString(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty $propertyReflection) : string
    {
        $stateModifier = '';
        if (!$propertyReflection->isStatic()) {
            $stateModifier = $propertyReflection->isDefault() ? ' <default>' : ' <dynamic>';
        }
        return \sprintf('Property [%s %s%s $%s ]', $stateModifier, self::visibilityToString($propertyReflection), $propertyReflection->isStatic() ? ' static' : '', $propertyReflection->getName());
    }
    private static function visibilityToString(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty $propertyReflection) : string
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
