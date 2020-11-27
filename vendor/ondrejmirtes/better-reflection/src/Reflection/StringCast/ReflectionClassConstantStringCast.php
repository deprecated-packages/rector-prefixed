<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\StringCast;

use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionClassConstant;
use function gettype;
use function is_array;
use function sprintf;
/**
 * @internal
 */
final class ReflectionClassConstantStringCast
{
    public static function toString(\_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionClassConstant $constantReflection) : string
    {
        $value = $constantReflection->getValue();
        return \sprintf("Constant [ %s %s %s ] { %s }\n", self::visibilityToString($constantReflection), \gettype($value), $constantReflection->getName(), \is_array($value) ? 'Array' : (string) $value);
    }
    private static function visibilityToString(\_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionClassConstant $constantReflection) : string
    {
        if ($constantReflection->isProtected()) {
            return 'protected';
        }
        if ($constantReflection->isPrivate()) {
            return 'private';
        }
        return 'public';
    }
}
