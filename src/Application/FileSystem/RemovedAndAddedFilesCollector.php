<?php

declare (strict_types=1);
namespace Rector\Core\Application\FileSystem;

use Rector\FileSystemRector\Contract\MovedFileInterface;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
use RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileInfo;
final class RemovedAndAddedFilesCollector
{
    /**
     * @var SmartFileInfo[]
     */
    private $removedFiles = [];
    /**
     * @var AddedFileWithContent[]
     */
    private $addedFileWithContents = [];
    /**
     * @var MovedFileInterface[]
     */
    private $movedFiles = [];
    public function removeFile(\RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->removedFiles[] = $smartFileInfo;
    }
    public function addMovedFile(\Rector\FileSystemRector\Contract\MovedFileInterface $movedFile) : void
    {
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
    public function getMovedFileByFileInfo(\RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : ?\Rector\FileSystemRector\Contract\MovedFileInterface
    {
        foreach ($this->movedFiles as $movedFile) {
            if ($movedFile->getOldPathname() !== $smartFileInfo->getPathname()) {
                continue;
            }
            return $movedFile;
        }
        return null;
    }
    public function isFileRemoved(\RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        foreach ($this->removedFiles as $removedFile) {
            if ($removedFile->getPathname() !== $smartFileInfo->getPathname()) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    public function addAddedFile(\Rector\FileSystemRector\ValueObject\AddedFileWithContent $addedFileWithContent) : void
    {
        $this->addedFileWithContents[] = $addedFileWithContent;
    }
    /**
     * @return AddedFileWithContent[]
     */
    public function getAddedFilesWithContent() : array
    {
        return $this->addedFileWithContents;
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
    public function getAffectedFilesCount() : int
    {
        return \count($this->addedFileWithContents) + \count($this->movedFiles) + \count($this->removedFiles);
    }
    public function getAddedFileCount() : int
    {
        return \count($this->addedFileWithContents);
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
        $this->addedFileWithContents = [];
        $this->removedFiles = [];
        $this->movedFiles = [];
    }
}
