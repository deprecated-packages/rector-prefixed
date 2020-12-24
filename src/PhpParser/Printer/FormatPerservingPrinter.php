<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @param Node[] $newStmts
     * @param Node[] $oldStmts
     * @param Node[] $oldTokens
     */
    public function printToFile(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, array $newStmts, array $oldStmts, array $oldTokens) : string
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
    public function printParsedStmstAndTokensToString(\_PhpScopere8e811afab72\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens $parsedStmtsAndTokens) : string
    {
        $newStmts = $this->resolveNewStmts($parsedStmtsAndTokens);
        return $this->betterStandardPrinter->printFormatPreserving($newStmts, $parsedStmtsAndTokens->getOldStmts(), $parsedStmtsAndTokens->getOldTokens());
    }
    public function printParsedStmstAndTokens(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \_PhpScopere8e811afab72\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens $parsedStmtsAndTokens) : string
    {
        return $this->printToFile($smartFileInfo, $parsedStmtsAndTokens->getNewStmts(), $parsedStmtsAndTokens->getOldStmts(), $parsedStmtsAndTokens->getOldTokens());
    }
    /**
     * @return Stmt[]|Node[]
     */
    private function resolveNewStmts(\_PhpScopere8e811afab72\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens $parsedStmtsAndTokens) : array
    {
        if (\count($parsedStmtsAndTokens->getNewStmts()) === 1) {
            $onlyStmt = $parsedStmtsAndTokens->getNewStmts()[0];
            if ($onlyStmt instanceof \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace) {
                return $onlyStmt->stmts;
            }
        }
        return $parsedStmtsAndTokens->getNewStmts();
    }
}
