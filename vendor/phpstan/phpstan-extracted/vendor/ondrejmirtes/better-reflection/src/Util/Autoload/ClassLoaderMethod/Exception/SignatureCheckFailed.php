<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod\Exception;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
use RuntimeException;
use function sprintf;
final class SignatureCheckFailed extends \RuntimeException
{
    public static function fromReflectionClass(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $reflectionClass) : self
    {
        return new self(\sprintf('Failed to verify the signature of the cached file for %s', $reflectionClass->getName()));
    }
}
