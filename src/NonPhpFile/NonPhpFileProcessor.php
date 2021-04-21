<?php

declare(strict_types=1);

namespace Rector\Core\NonPhpFile;

use Rector\Core\Configuration\RenamedClassesDataCollector;
use Rector\Core\Contract\Processor\FileProcessorInterface;
use Rector\Core\ValueObject\Application\File;
use Rector\Core\ValueObject\StaticNonPhpFileSuffixes;
use Rector\PSR4\Collector\RenamedClassesCollector;

/**
 * @see \Rector\Tests\Renaming\Rector\Name\RenameClassRector\RenameNonPhpTest
 */
final class NonPhpFileProcessor implements FileProcessorInterface
{
    /**
     * @var RenamedClassesDataCollector
     */
    private $renamedClassesDataCollector;

    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;

    /**
     * @var NonPhpFileClassRenamer
     */
    private $nonPhpFileClassRenamer;

    public function __construct(
        RenamedClassesDataCollector $renamedClassesDataCollector,
        RenamedClassesCollector $renamedClassesCollector,
        NonPhpFileClassRenamer $nonPhpFileClassRenamer
    ) {
        $this->renamedClassesDataCollector = $renamedClassesDataCollector;
        $this->renamedClassesCollector = $renamedClassesCollector;
        $this->nonPhpFileClassRenamer = $nonPhpFileClassRenamer;
    }

    /**
     * @param File[] $files
     * @return void
     */
    public function process(array $files)
    {
        foreach ($files as $file) {
            $this->processFile($file);
        }
    }

    public function supports(File $file): bool
    {
        $smartFileInfo = $file->getSmartFileInfo();
        return $smartFileInfo->hasSuffixes($this->getSupportedFileExtensions());
    }

    public function getSupportedFileExtensions(): array
    {
        return StaticNonPhpFileSuffixes::SUFFIXES;
    }

    /**
     * @return void
     */
    private function processFile(File $file)
    {
        $fileContent = $file->getFileContent();

        $classRenames = array_merge(
            $this->renamedClassesDataCollector->getOldToNewClasses(),
            $this->renamedClassesCollector->getOldToNewClasses()
        );

        $changedFileContents = $this->nonPhpFileClassRenamer->renameClasses($fileContent, $classRenames);
        $file->changeFileContent($changedFileContents);
    }
}
