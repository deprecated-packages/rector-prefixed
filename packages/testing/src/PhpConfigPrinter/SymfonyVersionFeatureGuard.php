<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Testing\PhpConfigPrinter;

use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
final class SymfonyVersionFeatureGuard implements \_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
{
    public function isAtLeastSymfonyVersion(float $symfonyVersion) : bool
    {
        return \true;
    }
}
