<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception;

use LogicException;
class EvaledClosureCannotBeLocated extends \LogicException
{
    public static function create() : self
    {
        return new self('Evaled closure cannot be located');
    }
}
