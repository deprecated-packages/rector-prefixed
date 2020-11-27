<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Exception;

use InvalidArgumentException;
use function sprintf;
class ObjectNotInstanceOfClass extends \InvalidArgumentException
{
    public static function fromClassName(string $className) : self
    {
        return new self(\sprintf('Object is not instance of class "%s"', $className));
    }
}
