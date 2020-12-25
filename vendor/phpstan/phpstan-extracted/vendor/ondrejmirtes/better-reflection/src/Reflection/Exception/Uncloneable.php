<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception;

use LogicException;
class Uncloneable extends \LogicException
{
    public static function fromClass(string $className) : self
    {
        return new self('Trying to clone an uncloneable object of class ' . $className);
    }
}
