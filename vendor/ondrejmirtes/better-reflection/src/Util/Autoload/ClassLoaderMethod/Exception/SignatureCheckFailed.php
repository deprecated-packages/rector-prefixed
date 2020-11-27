<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod\Exception;

use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionClass;
use RuntimeException;
use function sprintf;
final class SignatureCheckFailed extends \RuntimeException
{
    public static function fromReflectionClass(\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionClass $reflectionClass) : self
    {
        return new self(\sprintf('Failed to verify the signature of the cached file for %s', $reflectionClass->getName()));
    }
}
