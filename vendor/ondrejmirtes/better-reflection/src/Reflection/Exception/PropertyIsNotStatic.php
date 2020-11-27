<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Exception;

use RuntimeException;
use function sprintf;
class PropertyIsNotStatic extends \RuntimeException
{
    public static function fromName(string $propertyName) : self
    {
        return new self(\sprintf('Property "%s" is not static', $propertyName));
    }
}
