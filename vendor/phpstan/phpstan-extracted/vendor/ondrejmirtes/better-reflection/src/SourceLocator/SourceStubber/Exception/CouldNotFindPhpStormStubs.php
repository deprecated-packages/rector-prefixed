<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\Exception;

use RuntimeException;
class CouldNotFindPhpStormStubs extends \RuntimeException
{
    public static function create() : self
    {
        return new self('Could not find PhpStorm stubs');
    }
}
