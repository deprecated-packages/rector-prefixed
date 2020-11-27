<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Util\Autoload\Exception;

use LogicException;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionClass;
use function sprintf;
final class ClassAlreadyRegistered extends \LogicException
{
    public static function fromReflectionClass(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionClass $reflectionClass) : self
    {
        return new self(\sprintf('Class %s already registered', $reflectionClass->getName()));
    }
}
