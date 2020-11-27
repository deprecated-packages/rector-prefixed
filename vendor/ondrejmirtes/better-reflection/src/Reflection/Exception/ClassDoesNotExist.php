<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Exception;

use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Reflection;
use RuntimeException;
use function sprintf;
class ClassDoesNotExist extends \RuntimeException
{
    public static function forDifferentReflectionType(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Reflection $reflection) : self
    {
        return new self(\sprintf('The reflected type "%s" is not a class', $reflection->getName()));
    }
}
