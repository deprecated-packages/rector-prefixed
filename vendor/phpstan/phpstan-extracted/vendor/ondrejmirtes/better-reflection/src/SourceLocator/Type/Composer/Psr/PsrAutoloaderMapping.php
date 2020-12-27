<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\Composer\Psr;

use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
interface PsrAutoloaderMapping
{
    /** @return list<string> */
    public function resolvePossibleFilePaths(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : array;
    /** @return list<string> */
    public function directories() : array;
}
