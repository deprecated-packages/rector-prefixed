<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Scope;

use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Analyser\ScopeContext;
use _PhpScopere8e811afab72\PHPStan\Analyser\ScopeFactory as PHPStanScopeFactory;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ScopeFactory
{
    /**
     * @var PHPStanScopeFactory
     */
    private $phpStanScopeFactory;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Analyser\ScopeFactory $phpStanScopeFactory)
    {
        $this->phpStanScopeFactory = $phpStanScopeFactory;
    }
    public function createFromFile(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : \_PhpScopere8e811afab72\PHPStan\Analyser\Scope
    {
        return $this->phpStanScopeFactory->create(\_PhpScopere8e811afab72\PHPStan\Analyser\ScopeContext::create($fileInfo->getRealPath()));
    }
}
