<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Exception;

use InvalidArgumentException;
class NoObjectProvided extends \InvalidArgumentException
{
    public static function create() : self
    {
        return new self('No object provided');
    }
}
