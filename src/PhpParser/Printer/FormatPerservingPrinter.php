<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @param Node[] $newStmts
     * @param Node[] $oldStmts
     * @param Node[] $oldTokens
     */
    public function printToFile(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, array $newStmts, array $oldStmts, array $oldTokens) : string
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
    public function printParsedStmstAndTokensToString(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens $parsedStmtsAndTokens) : string
    {
        $newStmts = $this->resolveNewStmts($parsedStmtsAndTokens);
        return $this->betterStandardPrinter->printFormatPreserving($newStmts, $parsedStmtsAndTokens->getOldStmts(), $parsedStmtsAndTokens->getOldTokens());
    }
    public function printParsedStmstAndTokens(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens $parsedStmtsAndTokens) : string
    {
        return $this->printToFile($smartFileInfo, $parsedStmtsAndTokens->getNewStmts(), $parsedStmtsAndTokens->getOldStmts(), $parsedStmtsAndTokens->getOldTokens());
    }
    /**
     * @return Stmt[]|Node[]
     */
    private function resolveNewStmts(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\Application\ParsedStmtsAndTokens $parsedStmtsAndTokens) : array
    {
        if (\count($parsedStmtsAndTokens->getNewStmts()) === 1) {
            $onlyStmt = $parsedStmtsAndTokens->getNewStmts()[0];
            if ($onlyStmt instanceof \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace) {
                return $onlyStmt->stmts;
            }
        }
        return $parsedStmtsAndTokens->getNewStmts();
    }
}
