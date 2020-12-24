<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Application;

use _PhpScopere8e811afab72\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class TokensByFilePathStorage
{
    /**
     * @var ParsedStmtsAndTokens[]
     */
    private $tokensByFilePath = [];
    public function addForRealPath(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \_PhpScopere8e811afab72\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens $parsedStmtsAndTokens) : void
    {
        $this->tokensByFilePath[$smartFileInfo->getRealPath()] = $parsedStmtsAndTokens;
    }
    public function hasForFileInfo(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        return isset($this->tokensByFilePath[$smartFileInfo->getRealPath()]);
    }
    public function getForFileInfo(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \_PhpScopere8e811afab72\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens
    {
        return $this->tokensByFilePath[$smartFileInfo->getRealPath()];
    }
}
