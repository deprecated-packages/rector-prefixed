<?php

declare (strict_types=1);
namespace Rector\Core\Rector\AbstractRector;

use PhpParser\Node;
use Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\FileSystemRector\Contract\MovedFileInterface;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
use Rector\PSR4\Collector\RenamedClassesCollector;
use RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function autowireRemovedAndAddedFilesTrait(\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector $removedAndAddedFilesCollector, \Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector) : void
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
        $this->removedAndAddedFilesCollector->addAddedFile(new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($fileLocation, $fileContent));
    }
    protected function addMovedFile(\Rector\FileSystemRector\Contract\MovedFileInterface $movedFile) : void
    {
        if ($movedFile instanceof \Rector\FileSystemRector\ValueObject\MovedFileWithNodes && $movedFile->hasClassRename()) {
            $this->renamedClassesCollector->addClassRename($movedFile->getOldClassName(), $movedFile->getNewClassName());
        }
        $this->removedAndAddedFilesCollector->addMovedFile($movedFile);
    }
    protected function removeFile(\RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->removedAndAddedFilesCollector->removeFile($smartFileInfo);
    }
    private function addFile(\Rector\FileSystemRector\ValueObject\AddedFileWithContent $addedFileWithContent) : void
    {
        $this->removedAndAddedFilesCollector->addAddedFile($addedFileWithContent);
    }
}
