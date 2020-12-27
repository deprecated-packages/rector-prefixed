<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception;

use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use RuntimeException;
use function sprintf;
class ClassDoesNotExist extends \RuntimeException
{
    public static function forDifferentReflectionType(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection $reflection) : self
    {
        return new self(\sprintf('The reflected type "%s" is not a class', $reflection->getName()));
    }
}
