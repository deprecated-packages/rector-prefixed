<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Testing\PHPUnit\Behavior;

use _PhpScopere8e811afab72\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use _PhpScopere8e811afab72\Rector\FileSystemRector\Contract\MovedFileInterface;
use _PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @property-read RemovedAndAddedFilesCollector $removedAndAddedFilesCollector
 */
trait MovingFilesTrait
{
    protected function matchMovedFile(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \_PhpScopere8e811afab72\Rector\FileSystemRector\Contract\MovedFileInterface
    {
        return $this->removedAndAddedFilesCollector->getMovedFileByFileInfo($smartFileInfo);
    }
    protected function assertFileWasNotChanged(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $movedFile = $this->removedAndAddedFilesCollector->getMovedFileByFileInfo($smartFileInfo);
        $this->assertNull($movedFile);
    }
    protected function assertFileWithContentWasAdded(\_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent $addedFileWithContent) : void
    {
        $this->assertFilesWereAdded([$addedFileWithContent]);
    }
    protected function assertFileWasRemoved(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $isFileRemoved = $this->removedAndAddedFilesCollector->isFileRemoved($smartFileInfo);
        $this->assertTrue($isFileRemoved);
    }
    /**
     * @param AddedFileWithContent[] $addedFileWithContents
     */
    protected function assertFilesWereAdded(array $addedFileWithContents) : void
    {
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsAOf($addedFileWithContents, \_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent::class);
        $addedFilePathsWithContents = $this->removedAndAddedFilesCollector->getAddedFilesWithContent();
        \sort($addedFilePathsWithContents);
        \sort($addedFileWithContents);
        foreach ($addedFilePathsWithContents as $key => $addedFilePathWithContent) {
            $expectedFilePathWithContent = $addedFileWithContents[$key];
            $this->assertSame($expectedFilePathWithContent->getFilePath(), $addedFilePathWithContent->getFilePath());
            $this->assertSame($expectedFilePathWithContent->getFileContent(), $addedFilePathWithContent->getFileContent());
        }
    }
}
