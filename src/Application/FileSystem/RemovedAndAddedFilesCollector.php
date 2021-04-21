<?php

declare(strict_types=1);

namespace Rector\Core\Application\FileSystem;

use Rector\FileSystemRector\Contract\AddedFileInterface;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Rector\FileSystemRector\ValueObject\AddedFileWithNodes;
use Symplify\SmartFileSystem\SmartFileInfo;

final class RemovedAndAddedFilesCollector
{
    /**
     * @var SmartFileInfo[]
     */
    private $removedFileInfos = [];

    /**
     * @var AddedFileInterface[]
     */
    private $addedFiles = [];

    /**
     * @return void
     */
    public function removeFile(SmartFileInfo $smartFileInfo)
    {
        $this->removedFileInfos[] = $smartFileInfo;
    }

    /**
     * @return SmartFileInfo[]
     */
    public function getRemovedFiles(): array
    {
        return $this->removedFileInfos;
    }

    public function isFileRemoved(SmartFileInfo $smartFileInfo): bool
    {
        foreach ($this->removedFileInfos as $removedFileInfo) {
            if ($removedFileInfo->getPathname() !== $smartFileInfo->getPathname()) {
                continue;
            }

            return true;
        }

        return false;
    }

    /**
     * @return void
     */
    public function addAddedFile(AddedFileInterface $addedFile)
    {
        $this->addedFiles[] = $addedFile;
    }

    /**
     * @return AddedFileWithContent[]
     */
    public function getAddedFilesWithContent(): array
    {
        return array_filter($this->addedFiles, function (AddedFileInterface $addedFile): bool {
            return $addedFile instanceof AddedFileWithContent;
        });
    }

    /**
     * @return AddedFileWithNodes[]
     */
    public function getAddedFilesWithNodes(): array
    {
        return array_filter($this->addedFiles, function (AddedFileInterface $addedFile): bool {
            return $addedFile instanceof AddedFileWithNodes;
        });
    }

    public function getAffectedFilesCount(): int
    {
        return count($this->addedFiles) + count($this->removedFileInfos);
    }

    public function getAddedFileCount(): int
    {
        return count($this->addedFiles);
    }

    public function getRemovedFilesCount(): int
    {
        return count($this->removedFileInfos);
    }

    /**
     * For testing
     * @return void
     */
    public function reset()
    {
        $this->addedFiles = [];
        $this->removedFileInfos = [];
    }
}
