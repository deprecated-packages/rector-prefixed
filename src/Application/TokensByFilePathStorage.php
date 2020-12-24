<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Application;

use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class TokensByFilePathStorage
{
    /**
     * @var ParsedStmtsAndTokens[]
     */
    private $tokensByFilePath = [];
    public function addForRealPath(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens $parsedStmtsAndTokens) : void
    {
        $this->tokensByFilePath[$smartFileInfo->getRealPath()] = $parsedStmtsAndTokens;
    }
    public function hasForFileInfo(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        return isset($this->tokensByFilePath[$smartFileInfo->getRealPath()]);
    }
    public function getForFileInfo(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens
    {
        return $this->tokensByFilePath[$smartFileInfo->getRealPath()];
    }
}
