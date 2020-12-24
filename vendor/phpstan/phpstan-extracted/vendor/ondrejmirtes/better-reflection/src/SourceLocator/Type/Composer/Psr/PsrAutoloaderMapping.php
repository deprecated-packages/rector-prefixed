<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\Composer\Psr;

use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
interface PsrAutoloaderMapping
{
    /** @return list<string> */
    public function resolvePossibleFilePaths(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : array;
    /** @return list<string> */
    public function directories() : array;
}
