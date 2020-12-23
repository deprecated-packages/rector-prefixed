<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\Scope;

use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\ScopeContext;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\ScopeFactory as PHPStanScopeFactory;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class ScopeFactory
{
    /**
     * @var PHPStanScopeFactory
     */
    private $phpStanScopeFactory;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\ScopeFactory $phpStanScopeFactory)
    {
        $this->phpStanScopeFactory = $phpStanScopeFactory;
    }
    public function createFromFile(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope
    {
        return $this->phpStanScopeFactory->create(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\ScopeContext::create($fileInfo->getRealPath()));
    }
}
