<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\Contract\MovedFileInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
use _PhpScoper2a4e7ab1ecbc\Rector\PSR4\Collector\RenamedClassesCollector;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function autowireRemovedAndAddedFilesTrait(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector $removedAndAddedFilesCollector, \_PhpScoper2a4e7ab1ecbc\Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector) : void
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
        $this->removedAndAddedFilesCollector->addAddedFile(new \_PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\ValueObject\AddedFileWithContent($fileLocation, $fileContent));
    }
    protected function addMovedFile(\_PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\Contract\MovedFileInterface $movedFile) : void
    {
        if ($movedFile instanceof \_PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\ValueObject\MovedFileWithNodes && $movedFile->hasClassRename()) {
            $this->renamedClassesCollector->addClassRename($movedFile->getOldClassName(), $movedFile->getNewClassName());
        }
        $this->removedAndAddedFilesCollector->addMovedFile($movedFile);
    }
    protected function removeFile(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->removedAndAddedFilesCollector->removeFile($smartFileInfo);
    }
    private function addFile(\_PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\ValueObject\AddedFileWithContent $addedFileWithContent) : void
    {
        $this->removedAndAddedFilesCollector->addAddedFile($addedFileWithContent);
    }
}
