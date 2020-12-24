<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Application;

use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class TokensByFilePathStorage
{
    /**
     * @var ParsedStmtsAndTokens[]
     */
    private $tokensByFilePath = [];
    public function addForRealPath(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens $parsedStmtsAndTokens) : void
    {
        $this->tokensByFilePath[$smartFileInfo->getRealPath()] = $parsedStmtsAndTokens;
    }
    public function hasForFileInfo(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        return isset($this->tokensByFilePath[$smartFileInfo->getRealPath()]);
    }
    public function getForFileInfo(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens
    {
        return $this->tokensByFilePath[$smartFileInfo->getRealPath()];
    }
}
