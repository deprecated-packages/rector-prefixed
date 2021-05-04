<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Printer;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use Rector\Core\ValueObject\Application\File;
use Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210504\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @see \Rector\Core\Tests\PhpParser\Printer\FormatPerservingPrinterTest
 */
final class FormatPerservingPrinter
{
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \RectorPrefix20210504\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @param Node[] $newStmts
     * @param Node[] $oldStmts
     * @param Node[] $oldTokens
     */
    public function printToFile(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, array $newStmts, array $oldStmts, array $oldTokens) : string
    {
        $newContent = $this->betterStandardPrinter->printFormatPreserving($newStmts, $oldStmts, $oldTokens);
        $this->smartFileSystem->dumpFile($fileInfo->getRealPath(), $newContent);
        $this->smartFileSystem->chmod($fileInfo->getRealPath(), $fileInfo->getPerms());
        return $newContent;
    }
    public function printParsedStmstAndTokensToString(\Rector\Core\ValueObject\Application\File $file) : string
    {
        $newStmts = $this->resolveNewStmts($file);
        return $this->betterStandardPrinter->printFormatPreserving($newStmts, $file->getOldStmts(), $file->getOldTokens());
    }
    public function printParsedStmstAndTokens(\Rector\Core\ValueObject\Application\File $file) : string
    {
        return $this->printToFile($file->getSmartFileInfo(), $file->getNewStmts(), $file->getOldStmts(), $file->getOldTokens());
    }
    /**
     * @return Stmt[]|mixed[]
     */
    private function resolveNewStmts(\Rector\Core\ValueObject\Application\File $file) : array
    {
        if (\count($file->getNewStmts()) === 1) {
            $onlyStmt = $file->getNewStmts()[0];
            if ($onlyStmt instanceof \Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace) {
                return $onlyStmt->stmts;
            }
        }
        return $file->getNewStmts();
    }
}
