<?php

declare (strict_types=1);
namespace Rector\Core\Application\FileSystem;

use Rector\FileSystemRector\Contract\AddedFileInterface;
use Rector\FileSystemRector\Contract\MovedFileInterface;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Rector\FileSystemRector\ValueObject\AddedFileWithNodes;
use Rector\FileSystemRector\ValueObject\MovedFileWithContent;
use Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
use Rector\PSR4\Collector\RenamedClassesCollector;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
final class RemovedAndAddedFilesCollector
{
    /**
     * @var SmartFileInfo[]
     */
    private $removedFiles = [];
    /**
     * @var AddedFileInterface[]
     */
    private $addedFiles = [];
    /**
     * @var MovedFileInterface[]
     */
    private $movedFiles = [];
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;
    public function __construct(\Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector)
    {
        $this->renamedClassesCollector = $renamedClassesCollector;
    }
    public function removeFile(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->removedFiles[] = $smartFileInfo;
    }
    public function addMovedFile(\Rector\FileSystemRector\Contract\MovedFileInterface $movedFile) : void
    {
        if ($movedFile instanceof \Rector\FileSystemRector\ValueObject\MovedFileWithNodes && $movedFile->hasClassRename()) {
            $this->renamedClassesCollector->addClassRename($movedFile->getOldClassName(), $movedFile->getNewClassName());
        }
        $this->movedFiles[] = $movedFile;
    }
    /**
     * @return SmartFileInfo[]
     */
    public function getRemovedFiles() : array
    {
        return $this->removedFiles;
    }
    /**
     * @return MovedFileInterface[]
     */
    public function getMovedFiles() : array
    {
        return $this->movedFiles;
    }
    public function getMovedFileByFileInfo(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : ?\Rector\FileSystemRector\Contract\MovedFileInterface
    {
        foreach ($this->movedFiles as $movedFile) {
            if ($movedFile->getOldPathname() !== $smartFileInfo->getPathname()) {
                continue;
            }
            return $movedFile;
        }
        return null;
    }
    public function isFileRemoved(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        foreach ($this->removedFiles as $removedFile) {
            if ($removedFile->getPathname() !== $smartFileInfo->getPathname()) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    public function addAddedFile(\Rector\FileSystemRector\Contract\AddedFileInterface $addedFile) : void
    {
        $this->addedFiles[] = $addedFile;
    }
    /**
     * @return AddedFileWithContent[]
     */
    public function getAddedFilesWithContent() : array
    {
        return \array_filter($this->addedFiles, function (\Rector\FileSystemRector\Contract\AddedFileInterface $addedFile) : bool {
            return $addedFile instanceof \Rector\FileSystemRector\ValueObject\AddedFileWithContent;
        });
    }
    /**
     * @return AddedFileWithNodes[]
     */
    public function getAddedFilesWithNodes() : array
    {
        return \array_filter($this->addedFiles, function (\Rector\FileSystemRector\Contract\AddedFileInterface $addedFile) : bool {
            return $addedFile instanceof \Rector\FileSystemRector\ValueObject\AddedFileWithNodes;
        });
    }
    /**
     * @return MovedFileWithNodes[]
     */
    public function getMovedFileWithNodes() : array
    {
        return \array_filter($this->movedFiles, function (\Rector\FileSystemRector\Contract\MovedFileInterface $movedFile) : bool {
            return $movedFile instanceof \Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
        });
    }
    /**
     * @return MovedFileWithContent[]
     */
    public function getMovedFileWithContent() : array
    {
        return \array_filter($this->movedFiles, function (\Rector\FileSystemRector\Contract\MovedFileInterface $movedFile) : bool {
            return $movedFile instanceof \Rector\FileSystemRector\ValueObject\MovedFileWithContent;
        });
    }
    public function getAffectedFilesCount() : int
    {
        return \count($this->addedFiles) + \count($this->movedFiles) + \count($this->removedFiles);
    }
    public function getAddedFileCount() : int
    {
        return \count($this->addedFiles);
    }
    public function getRemovedFilesCount() : int
    {
        return \count($this->removedFiles);
    }
    /**
     * For testing
     */
    public function reset() : void
    {
        $this->addedFiles = [];
        $this->removedFiles = [];
        $this->movedFiles = [];
    }
}
