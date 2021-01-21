<?php

declare (strict_types=1);
namespace RectorPrefix20210121\Symplify\PhpConfigPrinter\Dummy;

use RectorPrefix20210121\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
final class DummySymfonyVersionFeatureGuard implements \RectorPrefix20210121\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
{
    public function isAtLeastSymfonyVersion(float $symfonyVersion) : bool
    {
        return \true;
    }
}
