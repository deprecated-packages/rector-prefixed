<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception;

use LogicException;
class EvaledAnonymousClassCannotBeLocated extends \LogicException
{
    public static function create() : self
    {
        return new self('Evaled anonymous class cannot be located');
    }
}
