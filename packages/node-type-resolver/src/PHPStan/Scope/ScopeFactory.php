<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PHPStan\Scope;

use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Analyser\ScopeContext;
use RectorPrefix20201227\PHPStan\Analyser\ScopeFactory as PHPStanScopeFactory;
use RectorPrefix20201227\Symplify\SmartFileSystem\SmartFileInfo;
final class ScopeFactory
{
    /**
     * @var PHPStanScopeFactory
     */
    private $phpStanScopeFactory;
    public function __construct(\RectorPrefix20201227\PHPStan\Analyser\ScopeFactory $phpStanScopeFactory)
    {
        $this->phpStanScopeFactory = $phpStanScopeFactory;
    }
    public function createFromFile(\RectorPrefix20201227\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : \RectorPrefix20201227\PHPStan\Analyser\Scope
    {
        return $this->phpStanScopeFactory->create(\RectorPrefix20201227\PHPStan\Analyser\ScopeContext::create($fileInfo->getRealPath()));
    }
}
