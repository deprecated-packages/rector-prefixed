<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Contract;

interface SymfonyVersionFeatureGuardInterface
{
    public function isAtLeastSymfonyVersion(float $symfonyVersion) : bool;
}
