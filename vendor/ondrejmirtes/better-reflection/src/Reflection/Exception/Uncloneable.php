<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Exception;

use LogicException;
class Uncloneable extends \LogicException
{
    public static function fromClass(string $className) : self
    {
        return new self('Trying to clone an uncloneable object of class ' . $className);
    }
}
