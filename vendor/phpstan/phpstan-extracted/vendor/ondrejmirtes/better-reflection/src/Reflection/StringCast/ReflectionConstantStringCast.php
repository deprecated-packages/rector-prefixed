<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\StringCast;

use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant;
use function assert;
use function gettype;
use function is_scalar;
use function sprintf;
/**
 * Implementation of ReflectionConstant::__toString()
 *
 * @internal
 */
final class ReflectionConstantStringCast
{
    public static function toString(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant $constantReflection) : string
    {
        $value = $constantReflection->getValue();
        \assert($value === null || \is_scalar($value));
        return \sprintf('Constant [ <%s> %s %s ] {%s %s }', self::sourceToString($constantReflection), \gettype($value), $constantReflection->getName(), self::fileAndLinesToString($constantReflection), (string) $value);
    }
    private static function sourceToString(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant $constantReflection) : string
    {
        if ($constantReflection->isUserDefined()) {
            return 'user';
        }
        return \sprintf('internal:%s', $constantReflection->getExtensionName());
    }
    private static function fileAndLinesToString(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant $constantReflection) : string
    {
        if ($constantReflection->isInternal()) {
            return '';
        }
        return \sprintf("\n  @@ %s %d - %d\n", $constantReflection->getFileName(), $constantReflection->getStartLine(), $constantReflection->getEndLine());
    }
}
