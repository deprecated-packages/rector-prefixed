<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\Exception;

use LogicException;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
use function sprintf;
final class ClassAlreadyRegistered extends \LogicException
{
    public static function fromReflectionClass(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $reflectionClass) : self
    {
        return new self(\sprintf('Class %s already registered', $reflectionClass->getName()));
    }
}
