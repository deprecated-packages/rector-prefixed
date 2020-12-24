<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Testing\PhpConfigPrinter;

use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
final class SymfonyVersionFeatureGuard implements \_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
{
    public function isAtLeastSymfonyVersion(float $symfonyVersion) : bool
    {
        return \true;
    }
}
