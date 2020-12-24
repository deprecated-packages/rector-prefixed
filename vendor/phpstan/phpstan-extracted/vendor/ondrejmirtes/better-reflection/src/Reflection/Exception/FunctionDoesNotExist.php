<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception;

use RuntimeException;
use function sprintf;
class FunctionDoesNotExist extends \RuntimeException
{
    public static function fromName(string $functionName) : self
    {
        return new self(\sprintf('Function "%s" cannot be used as the function is not loaded', $functionName));
    }
}
