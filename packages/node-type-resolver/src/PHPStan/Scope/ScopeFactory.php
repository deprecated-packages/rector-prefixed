<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Scope;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\ScopeContext;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\ScopeFactory as PHPStanScopeFactory;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class ScopeFactory
{
    /**
     * @var PHPStanScopeFactory
     */
    private $phpStanScopeFactory;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\ScopeFactory $phpStanScopeFactory)
    {
        $this->phpStanScopeFactory = $phpStanScopeFactory;
    }
    public function createFromFile(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope
    {
        return $this->phpStanScopeFactory->create(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\ScopeContext::create($fileInfo->getRealPath()));
    }
}
