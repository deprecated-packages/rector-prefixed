<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @see \Rector\Core\Tests\PhpParser\Printer\FormatPerservingPrinterTest
 */
final class FormatPerservingPrinter
{
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @param Node[] $newStmts
     * @param Node[] $oldStmts
     * @param Node[] $oldTokens
     */
    public function printToFile(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, array $newStmts, array $oldStmts, array $oldTokens) : string
    {
        $newContent = $this->printToString($newStmts, $oldStmts, $oldTokens);
        $this->smartFileSystem->dumpFile($fileInfo->getRealPath(), $newContent);
        $this->smartFileSystem->chmod($fileInfo->getRealPath(), $fileInfo->getPerms());
        return $newContent;
    }
    /**
     * @param Node[] $newStmts
     * @param Node[] $oldStmts
     * @param Node[] $oldTokens
     */
    public function printToString(array $newStmts, array $oldStmts, array $oldTokens) : string
    {
        return $this->betterStandardPrinter->printFormatPreserving($newStmts, $oldStmts, $oldTokens);
    }
    public function printParsedStmstAndTokensToString(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens $parsedStmtsAndTokens) : string
    {
        $newStmts = $this->resolveNewStmts($parsedStmtsAndTokens);
        return $this->betterStandardPrinter->printFormatPreserving($newStmts, $parsedStmtsAndTokens->getOldStmts(), $parsedStmtsAndTokens->getOldTokens());
    }
    public function printParsedStmstAndTokens(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens $parsedStmtsAndTokens) : string
    {
        return $this->printToFile($smartFileInfo, $parsedStmtsAndTokens->getNewStmts(), $parsedStmtsAndTokens->getOldStmts(), $parsedStmtsAndTokens->getOldTokens());
    }
    /**
     * @return Stmt[]|Node[]
     */
    private function resolveNewStmts(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens $parsedStmtsAndTokens) : array
    {
        if (\count($parsedStmtsAndTokens->getNewStmts()) === 1) {
            $onlyStmt = $parsedStmtsAndTokens->getNewStmts()[0];
            if ($onlyStmt instanceof \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace) {
                return $onlyStmt->stmts;
            }
        }
        return $parsedStmtsAndTokens->getNewStmts();
    }
}
