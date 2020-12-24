<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\FileSystem;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class CurrentFileInfoProvider
{
    /**
     * @var Node[]
     */
    private $currentStmts = [];
    /**
     * @var SmartFileInfo|null
     */
    private $smartFileInfo;
    public function setCurrentFileInfo(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->smartFileInfo = $smartFileInfo;
    }
    public function getSmartFileInfo() : ?\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->smartFileInfo;
    }
    /**
     * @param Node[] $stmts
     */
    public function setCurrentStmts(array $stmts) : void
    {
        $this->currentStmts = $stmts;
    }
    /**
     * @return Node[]
     */
    public function getCurrentStmts() : array
    {
        return $this->currentStmts;
    }
}
