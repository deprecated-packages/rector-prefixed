<?php

declare (strict_types=1);
namespace Rector\Core\Application\FileSystem;

use Rector\Core\Configuration\Configuration;
use Rector\Core\Exception\NotImplementedYetException;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\Core\PhpParser\Printer\NodesWithFileDestinationPrinter;
use Rector\FileSystemRector\Contract\MovedFileInterface;
use Rector\FileSystemRector\ValueObject\MovedFileWithContent;
use Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
use Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use RectorPrefix20210408\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\Rector\Core\Configuration\Configuration $configuration, \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Rector\Core\PhpParser\Printer\NodesWithFileDestinationPrinter $nodesWithFileDestinationPrinter, \Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector $removedAndAddedFilesCollector, \RectorPrefix20210408\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
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
        $this->processAddedFilesWithContent();
        $this->processAddedFilesWithNodes();
        $this->processMovedFiles();
        $this->processMovedFilesWithNodes();
        $this->processDeletedFiles();
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
            if ($this->configuration->isDryRun() && !\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
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
                $message = \sprintf('File "%s" will be added', $addedFileWithContent->getFilePath());
                $this->symfonyStyle->note($message);
            } else {
                $this->smartFileSystem->dumpFile($addedFileWithContent->getFilePath(), $addedFileWithContent->getFileContent());
                $message = \sprintf('File "%s" was added', $addedFileWithContent->getFilePath());
                $this->symfonyStyle->note($message);
            }
        }
    }
    private function processAddedFilesWithNodes() : void
    {
        foreach ($this->removedAndAddedFilesCollector->getAddedFilesWithNodes() as $addedFileWithNode) {
            $fileContent = $this->nodesWithFileDestinationPrinter->printNodesWithFileDestination($addedFileWithNode);
            if ($this->configuration->isDryRun()) {
                $message = \sprintf('File "%s" will be added', $addedFileWithNode->getFilePath());
                $this->symfonyStyle->note($message);
            } else {
                $this->smartFileSystem->dumpFile($addedFileWithNode->getFilePath(), $fileContent);
                $message = \sprintf('File "%s" was added', $addedFileWithNode->getFilePath());
                $this->symfonyStyle->note($message);
            }
        }
    }
    private function processMovedFilesWithNodes() : void
    {
        foreach ($this->removedAndAddedFilesCollector->getMovedFileWithNodes() as $movedFileWithNodes) {
            $fileContent = $this->nodesWithFileDestinationPrinter->printNodesWithFileDestination($movedFileWithNodes);
            if ($this->configuration->isDryRun()) {
                $message = \sprintf('File "%s" will be moved to "%s"', $movedFileWithNodes->getOldPathname(), $movedFileWithNodes->getNewPathname());
                $this->symfonyStyle->note($message);
            } else {
                $this->smartFileSystem->dumpFile($movedFileWithNodes->getNewPathname(), $fileContent);
                $message = \sprintf('File "%s" was moved to "%s":', $movedFileWithNodes->getOldPathname(), $movedFileWithNodes->getNewPathname());
                $this->symfonyStyle->note($message);
            }
        }
    }
    private function printFileMoveWarning(\Rector\FileSystemRector\Contract\MovedFileInterface $movedFile, string $verb) : void
    {
        $message = \sprintf('File "%s" %s moved to "%s"', $movedFile->getOldPathname(), $verb, $movedFile->getNewPathname());
        $this->symfonyStyle->warning($message);
    }
    private function resolveFileContentFromMovedFile(\Rector\FileSystemRector\Contract\MovedFileInterface $movedFile) : string
    {
        if ($movedFile instanceof \Rector\FileSystemRector\ValueObject\MovedFileWithContent) {
            return $movedFile->getFileContent();
        }
        if ($movedFile instanceof \Rector\FileSystemRector\ValueObject\MovedFileWithNodes) {
            return $this->betterStandardPrinter->prettyPrintFile($movedFile->getNodes());
        }
        throw new \Rector\Core\Exception\NotImplementedYetException(\get_class($movedFile));
    }
}
