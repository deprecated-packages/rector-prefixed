<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\Exception;

use LogicException;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
use function sprintf;
final class ClassAlreadyLoaded extends \LogicException
{
    public static function fromReflectionClass(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $reflectionClass) : self
    {
        return new self(\sprintf('Class %s has already been loaded into memory so cannot be modified', $reflectionClass->getName()));
    }
}
