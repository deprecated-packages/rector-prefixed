<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Type\Composer\Psr;

use _PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier;
interface PsrAutoloaderMapping
{
    /** @return list<string> */
    public function resolvePossibleFilePaths(\_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier $identifier) : array;
    /** @return list<string> */
    public function directories() : array;
}
