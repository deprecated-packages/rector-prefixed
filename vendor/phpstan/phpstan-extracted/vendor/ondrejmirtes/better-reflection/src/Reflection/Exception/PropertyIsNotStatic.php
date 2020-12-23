<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception;

use RuntimeException;
use function sprintf;
class PropertyIsNotStatic extends \RuntimeException
{
    public static function fromName(string $propertyName) : self
    {
        return new self(\sprintf('Property "%s" is not static', $propertyName));
    }
}
