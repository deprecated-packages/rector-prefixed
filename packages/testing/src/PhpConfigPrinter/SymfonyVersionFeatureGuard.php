<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Testing\PhpConfigPrinter;

use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
final class SymfonyVersionFeatureGuard implements \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
{
    public function isAtLeastSymfonyVersion(float $symfonyVersion) : bool
    {
        return \true;
    }
}
