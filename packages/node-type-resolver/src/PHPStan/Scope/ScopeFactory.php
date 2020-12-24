<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Scope;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\ScopeContext;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\ScopeFactory as PHPStanScopeFactory;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ScopeFactory
{
    /**
     * @var PHPStanScopeFactory
     */
    private $phpStanScopeFactory;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Analyser\ScopeFactory $phpStanScopeFactory)
    {
        $this->phpStanScopeFactory = $phpStanScopeFactory;
    }
    public function createFromFile(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope
    {
        return $this->phpStanScopeFactory->create(\_PhpScoperb75b35f52b74\PHPStan\Analyser\ScopeContext::create($fileInfo->getRealPath()));
    }
}
