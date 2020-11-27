<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\Util\Autoload\Exception;

use LogicException;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionClass;
use function sprintf;
final class ClassAlreadyRegistered extends \LogicException
{
    public static function fromReflectionClass(\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionClass $reflectionClass) : self
    {
        return new self(\sprintf('Class %s already registered', $reflectionClass->getName()));
    }
}
