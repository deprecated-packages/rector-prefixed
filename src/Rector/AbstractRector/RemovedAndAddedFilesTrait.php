<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\FileSystemRector\Contract\MovedFileInterface;
use _PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
use _PhpScoperb75b35f52b74\Rector\PSR4\Collector\RenamedClassesCollector;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * This could be part of @see AbstractRector, but decopuling to trait
 * makes clear what code has 1 purpose.
 *
 * @property BetterStandardPrinter $betterStandardPrinter
 */
trait RemovedAndAddedFilesTrait
{
    /**
     * @var RemovedAndAddedFilesCollector
     */
    private $removedAndAddedFilesCollector;
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;
    /**
     * @required
     */
    public function autowireRemovedAndAddedFilesTrait(\_PhpScoperb75b35f52b74\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector $removedAndAddedFilesCollector, \_PhpScoperb75b35f52b74\Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector) : void
    {
        $this->removedAndAddedFilesCollector = $removedAndAddedFilesCollector;
        $this->renamedClassesCollector = $renamedClassesCollector;
    }
    /**
     * @param Node[] $nodes
     */
    protected function printNodesToFilePath(array $nodes, string $fileLocation) : void
    {
        $fileContent = $this->betterStandardPrinter->prettyPrintFile($nodes);
        $this->removedAndAddedFilesCollector->addAddedFile(new \_PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\AddedFileWithContent($fileLocation, $fileContent));
    }
    protected function addMovedFile(\_PhpScoperb75b35f52b74\Rector\FileSystemRector\Contract\MovedFileInterface $movedFile) : void
    {
        if ($movedFile instanceof \_PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\MovedFileWithNodes && $movedFile->hasClassRename()) {
            $this->renamedClassesCollector->addClassRename($movedFile->getOldClassName(), $movedFile->getNewClassName());
        }
        $this->removedAndAddedFilesCollector->addMovedFile($movedFile);
    }
    protected function removeFile(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->removedAndAddedFilesCollector->removeFile($smartFileInfo);
    }
    private function addFile(\_PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\AddedFileWithContent $addedFileWithContent) : void
    {
        $this->removedAndAddedFilesCollector->addAddedFile($addedFileWithContent);
    }
}
