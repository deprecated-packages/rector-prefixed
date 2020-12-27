<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Exception;

use InvalidArgumentException;
use function sprintf;
class InvalidIdentifierName extends \InvalidArgumentException
{
    public static function fromInvalidName(string $name) : self
    {
        return new self(\sprintf('Invalid identifier name "%s"', $name));
    }
}
