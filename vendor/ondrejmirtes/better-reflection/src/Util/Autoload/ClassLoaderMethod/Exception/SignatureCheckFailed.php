<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod\Exception;

use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionClass;
use RuntimeException;
use function sprintf;
final class SignatureCheckFailed extends \RuntimeException
{
    public static function fromReflectionClass(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionClass $reflectionClass) : self
    {
        return new self(\sprintf('Failed to verify the signature of the cached file for %s', $reflectionClass->getName()));
    }
}
