<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\FileSystem;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function setCurrentFileInfo(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->smartFileInfo = $smartFileInfo;
    }
    public function getSmartFileInfo() : ?\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo
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
