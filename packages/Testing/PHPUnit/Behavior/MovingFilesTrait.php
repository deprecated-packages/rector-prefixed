<?php
declare(strict_types=1);

namespace Rector\Testing\PHPUnit\Behavior;

use Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use Rector\Core\PhpParser\Printer\NodesWithFileDestinationPrinter;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Symplify\SmartFileSystem\SmartFileInfo;
use Webmozart\Assert\Assert;

/**
 * @property-read RemovedAndAddedFilesCollector $removedAndAddedFilesCollector
 */
trait MovingFilesTrait
{
    /**
     * @return void
     */
    protected function assertFileWasNotChanged(SmartFileInfo $smartFileInfo)
    {
        $hasFileInfo = $this->removedAndAddedFilesCollector->isFileRemoved($smartFileInfo);
        $this->assertFalse($hasFileInfo);
    }

    /**
     * @return void
     */
    protected function assertFileWasAdded(AddedFileWithContent $addedFileWithContent)
    {
        $this->assertFilesWereAdded([$addedFileWithContent]);
    }

    /**
     * @return void
     */
    protected function assertFileWasRemoved(SmartFileInfo $smartFileInfo)
    {
        $isFileRemoved = $this->removedAndAddedFilesCollector->isFileRemoved($smartFileInfo);
        $this->assertTrue($isFileRemoved);
    }

    /**
     * @param AddedFileWithContent[] $expectedAddedFileWithContents
     * @return void
     */
    protected function assertFilesWereAdded(array $expectedAddedFileWithContents)
    {
        Assert::allIsAOf($expectedAddedFileWithContents, AddedFileWithContent::class);
        sort($expectedAddedFileWithContents);

        $addedFilePathsWithContents = $this->resolveAddedFilePathsWithContents();
        sort($addedFilePathsWithContents);

        // there should be at least some added files
        Assert::notEmpty($addedFilePathsWithContents);

        foreach ($addedFilePathsWithContents as $key => $addedFilePathWithContent) {
            $expectedFilePathWithContent = $expectedAddedFileWithContents[$key];

            $this->assertSame(
                $expectedFilePathWithContent->getFilePath(),
                $addedFilePathWithContent->getFilePath()
            );

            $this->assertSame(
                $expectedFilePathWithContent->getFileContent(),
                $addedFilePathWithContent->getFileContent()
            );
        }
    }

    /**
     * @return AddedFileWithContent[]
     */
    private function resolveAddedFilePathsWithContents(): array
    {
        $addedFilePathsWithContents = $this->removedAndAddedFilesCollector->getAddedFilesWithContent();

        $addedFilesWithNodes = $this->removedAndAddedFilesCollector->getAddedFilesWithNodes();

        foreach ($addedFilesWithNodes as $addedFileWithNode) {
            $nodesWithFileDestinationPrinter = $this->getService(NodesWithFileDestinationPrinter::class);
            $fileContent = $nodesWithFileDestinationPrinter->printNodesWithFileDestination($addedFileWithNode);
            $addedFilePathsWithContents[] = new AddedFileWithContent($addedFileWithNode->getFilePath(), $fileContent);
        }

        return $addedFilePathsWithContents;
    }
}
