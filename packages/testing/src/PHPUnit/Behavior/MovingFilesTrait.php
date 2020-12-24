<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\Behavior;

use _PhpScoperb75b35f52b74\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use _PhpScoperb75b35f52b74\Rector\FileSystemRector\Contract\MovedFileInterface;
use _PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @property-read RemovedAndAddedFilesCollector $removedAndAddedFilesCollector
 */
trait MovingFilesTrait
{
    protected function matchMovedFile(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \_PhpScoperb75b35f52b74\Rector\FileSystemRector\Contract\MovedFileInterface
    {
        return $this->removedAndAddedFilesCollector->getMovedFileByFileInfo($smartFileInfo);
    }
    protected function assertFileWasNotChanged(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $movedFile = $this->removedAndAddedFilesCollector->getMovedFileByFileInfo($smartFileInfo);
        $this->assertNull($movedFile);
    }
    protected function assertFileWithContentWasAdded(\_PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\AddedFileWithContent $addedFileWithContent) : void
    {
        $this->assertFilesWereAdded([$addedFileWithContent]);
    }
    protected function assertFileWasRemoved(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $isFileRemoved = $this->removedAndAddedFilesCollector->isFileRemoved($smartFileInfo);
        $this->assertTrue($isFileRemoved);
    }
    /**
     * @param AddedFileWithContent[] $addedFileWithContents
     */
    protected function assertFilesWereAdded(array $addedFileWithContents) : void
    {
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsAOf($addedFileWithContents, \_PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\AddedFileWithContent::class);
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
