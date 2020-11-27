<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\SourceStubber\Exception;

use RuntimeException;
class CouldNotFindPhpStormStubs extends \RuntimeException
{
    public static function create() : self
    {
        return new self('Could not find PhpStorm stubs');
    }
}
