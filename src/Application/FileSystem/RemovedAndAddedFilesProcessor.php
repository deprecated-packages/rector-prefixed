<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Application\FileSystem;

use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Configuration;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\NodesWithFileDestinationPrinter;
use _PhpScoperb75b35f52b74\Rector\FileSystemRector\Contract\MovedFileInterface;
use _PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\MovedFileWithContent;
use _PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * Adds and removes scheduled file
 */
final class RemovedAndAddedFilesProcessor
{
    /**
     * @var RemovedAndAddedFilesCollector
     */
    private $removedAndAddedFilesCollector;
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var NodesWithFileDestinationPrinter
     */
    private $nodesWithFileDestinationPrinter;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Configuration $configuration, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\NodesWithFileDestinationPrinter $nodesWithFileDestinationPrinter, \_PhpScoperb75b35f52b74\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector $removedAndAddedFilesCollector, \_PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->removedAndAddedFilesCollector = $removedAndAddedFilesCollector;
        $this->configuration = $configuration;
        $this->symfonyStyle = $symfonyStyle;
        $this->nodesWithFileDestinationPrinter = $nodesWithFileDestinationPrinter;
        $this->smartFileSystem = $smartFileSystem;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    public function run() : void
    {
        $this->processAddedFiles();
        $this->processDeletedFiles();
        $this->processMovedFiles();
    }
    private function processAddedFiles() : void
    {
        $this->processAddedFilesWithContent();
        $this->processAddedFilesWithNodes();
    }
    private function processDeletedFiles() : void
    {
        foreach ($this->removedAndAddedFilesCollector->getRemovedFiles() as $removedFile) {
            $relativePath = $removedFile->getRelativeFilePathFromDirectory(\getcwd());
            if ($this->configuration->isDryRun()) {
                $message = \sprintf('File "%s" will be removed', $relativePath);
                $this->symfonyStyle->warning($message);
            } else {
                $message = \sprintf('File "%s" was removed', $relativePath);
                $this->symfonyStyle->warning($message);
                $this->smartFileSystem->remove($removedFile->getPathname());
            }
        }
    }
    private function processMovedFiles() : void
    {
        foreach ($this->removedAndAddedFilesCollector->getMovedFiles() as $movedFile) {
            if ($this->configuration->isDryRun() && !\_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
                $this->printFileMoveWarning($movedFile, 'will be');
            } else {
                $this->printFileMoveWarning($movedFile, 'was');
                $this->smartFileSystem->remove($movedFile->getOldPathname());
                $fileContent = $this->resolveFileContentFromMovedFile($movedFile);
                $this->smartFileSystem->dumpFile($movedFile->getNewPathname(), $fileContent);
            }
        }
    }
    private function processAddedFilesWithContent() : void
    {
        foreach ($this->removedAndAddedFilesCollector->getAddedFilesWithContent() as $addedFileWithContent) {
            if ($this->configuration->isDryRun()) {
                $message = \sprintf('File "%s" will be added:', $addedFileWithContent->getFilePath());
                $this->symfonyStyle->note($message);
            } else {
                $this->smartFileSystem->dumpFile($addedFileWithContent->getFilePath(), $addedFileWithContent->getFileContent());
                $message = \sprintf('File "%s" was added:', $addedFileWithContent->getFilePath());
                $this->symfonyStyle->note($message);
            }
        }
    }
    private function processAddedFilesWithNodes() : void
    {
        foreach ($this->removedAndAddedFilesCollector->getMovedFileWithNodes() as $addedFileWithNodes) {
            $fileContent = $this->nodesWithFileDestinationPrinter->printNodesWithFileDestination($addedFileWithNodes);
            if ($this->configuration->isDryRun()) {
                $message = \sprintf('File "%s" will be added:', $addedFileWithNodes->getOldPathname());
                $this->symfonyStyle->note($message);
            } else {
                $this->smartFileSystem->dumpFile($addedFileWithNodes->getNewPathname(), $fileContent);
                $message = \sprintf('File "%s" was added:', $addedFileWithNodes->getNewPathname());
                $this->symfonyStyle->note($message);
            }
        }
    }
    private function printFileMoveWarning(\_PhpScoperb75b35f52b74\Rector\FileSystemRector\Contract\MovedFileInterface $movedFile, string $verb) : void
    {
        $message = \sprintf('File "%s" %s moved to "%s"', $movedFile->getOldPathname(), $verb, $movedFile->getNewPathname());
        $this->symfonyStyle->warning($message);
    }
    private function resolveFileContentFromMovedFile(\_PhpScoperb75b35f52b74\Rector\FileSystemRector\Contract\MovedFileInterface $movedFile) : string
    {
        if ($movedFile instanceof \_PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\MovedFileWithContent) {
            return $movedFile->getFileContent();
        }
        if ($movedFile instanceof \_PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\MovedFileWithNodes) {
            return $this->betterStandardPrinter->prettyPrintFile($movedFile->getNodes());
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedYetException(\get_class($movedFile));
    }
}
