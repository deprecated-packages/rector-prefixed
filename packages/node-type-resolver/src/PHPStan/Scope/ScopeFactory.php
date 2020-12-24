<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Scope;

use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeContext;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeFactory as PHPStanScopeFactory;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ScopeFactory
{
    /**
     * @var PHPStanScopeFactory
     */
    private $phpStanScopeFactory;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeFactory $phpStanScopeFactory)
    {
        $this->phpStanScopeFactory = $phpStanScopeFactory;
    }
    public function createFromFile(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope
    {
        return $this->phpStanScopeFactory->create(\_PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeContext::create($fileInfo->getRealPath()));
    }
}
