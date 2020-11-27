<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Exception;

use RuntimeException;
use function sprintf;
class FunctionDoesNotExist extends \RuntimeException
{
    public static function fromName(string $functionName) : self
    {
        return new self(\sprintf('Function "%s" cannot be used as the function is not loaded', $functionName));
    }
}
