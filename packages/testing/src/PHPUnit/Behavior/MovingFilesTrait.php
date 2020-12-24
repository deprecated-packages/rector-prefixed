<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\Behavior;

use _PhpScoper0a6b37af0871\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use _PhpScoper0a6b37af0871\Rector\FileSystemRector\Contract\MovedFileInterface;
use _PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper0a6b37af0871\Webmozart\Assert\Assert;
/**
 * @property-read RemovedAndAddedFilesCollector $removedAndAddedFilesCollector
 */
trait MovingFilesTrait
{
    protected function matchMovedFile(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \_PhpScoper0a6b37af0871\Rector\FileSystemRector\Contract\MovedFileInterface
    {
        return $this->removedAndAddedFilesCollector->getMovedFileByFileInfo($smartFileInfo);
    }
    protected function assertFileWasNotChanged(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $movedFile = $this->removedAndAddedFilesCollector->getMovedFileByFileInfo($smartFileInfo);
        $this->assertNull($movedFile);
    }
    protected function assertFileWithContentWasAdded(\_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent $addedFileWithContent) : void
    {
        $this->assertFilesWereAdded([$addedFileWithContent]);
    }
    protected function assertFileWasRemoved(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $isFileRemoved = $this->removedAndAddedFilesCollector->isFileRemoved($smartFileInfo);
        $this->assertTrue($isFileRemoved);
    }
    /**
     * @param AddedFileWithContent[] $addedFileWithContents
     */
    protected function assertFilesWereAdded(array $addedFileWithContents) : void
    {
        \_PhpScoper0a6b37af0871\Webmozart\Assert\Assert::allIsAOf($addedFileWithContents, \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent::class);
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
