<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Exception;

use LogicException;
class EvaledClosureCannotBeLocated extends \LogicException
{
    public static function create() : self
    {
        return new self('Evaled closure cannot be located');
    }
}
