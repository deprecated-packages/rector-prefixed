<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Util\Autoload\Exception;

use LogicException;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionClass;
use function sprintf;
final class ClassAlreadyLoaded extends \LogicException
{
    public static function fromReflectionClass(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionClass $reflectionClass) : self
    {
        return new self(\sprintf('Class %s has already been loaded into memory so cannot be modified', $reflectionClass->getName()));
    }
}
