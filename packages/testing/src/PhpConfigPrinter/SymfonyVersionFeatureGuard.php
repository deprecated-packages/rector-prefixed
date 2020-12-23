<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Testing\PhpConfigPrinter;

use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
final class SymfonyVersionFeatureGuard implements \_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
{
    public function isAtLeastSymfonyVersion(float $symfonyVersion) : bool
    {
        return \true;
    }
}
