<?php

declare(strict_types=1);

namespace Rector\Core\Application\FileSystem;

use Rector\Core\Configuration\Configuration;
use Rector\Core\PhpParser\Printer\NodesWithFileDestinationPrinter;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\SmartFileSystem\SmartFileSystem;

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

    public function __construct(
        Configuration $configuration,
        SmartFileSystem $smartFileSystem,
        NodesWithFileDestinationPrinter $nodesWithFileDestinationPrinter,
        RemovedAndAddedFilesCollector $removedAndAddedFilesCollector,
        SymfonyStyle $symfonyStyle
    ) {
        $this->removedAndAddedFilesCollector = $removedAndAddedFilesCollector;
        $this->configuration = $configuration;
        $this->symfonyStyle = $symfonyStyle;
        $this->nodesWithFileDestinationPrinter = $nodesWithFileDestinationPrinter;
        $this->smartFileSystem = $smartFileSystem;
    }

    /**
     * @return void
     */
    public function run()
    {
        $this->processAddedFilesWithContent();
        $this->processAddedFilesWithNodes();

        $this->processDeletedFiles();
    }

    /**
     * @return void
     */
    private function processDeletedFiles()
    {
        foreach ($this->removedAndAddedFilesCollector->getRemovedFiles() as $removedFile) {
            $relativePath = $removedFile->getRelativeFilePathFromDirectory(getcwd());

            if ($this->configuration->isDryRun()) {
                $message = sprintf('File "%s" will be removed', $relativePath);
                $this->symfonyStyle->warning($message);
            } else {
                $message = sprintf('File "%s" was removed', $relativePath);
                $this->symfonyStyle->warning($message);
                $this->smartFileSystem->remove($removedFile->getPathname());
            }
        }
    }

    /**
     * @return void
     */
    private function processAddedFilesWithContent()
    {
        foreach ($this->removedAndAddedFilesCollector->getAddedFilesWithContent() as $addedFileWithContent) {
            if ($this->configuration->isDryRun()) {
                $message = sprintf('File "%s" will be added', $addedFileWithContent->getFilePath());
                $this->symfonyStyle->note($message);
            } else {
                $this->smartFileSystem->dumpFile(
                    $addedFileWithContent->getFilePath(),
                    $addedFileWithContent->getFileContent()
                );
                $message = sprintf('File "%s" was added', $addedFileWithContent->getFilePath());
                $this->symfonyStyle->note($message);
            }
        }
    }

    /**
     * @return void
     */
    private function processAddedFilesWithNodes()
    {
        foreach ($this->removedAndAddedFilesCollector->getAddedFilesWithNodes() as $addedFileWithNode) {
            $fileContent = $this->nodesWithFileDestinationPrinter->printNodesWithFileDestination(
                $addedFileWithNode
            );

            if ($this->configuration->isDryRun()) {
                $message = sprintf('File "%s" will be added', $addedFileWithNode->getFilePath());
                $this->symfonyStyle->note($message);
            } else {
                $this->smartFileSystem->dumpFile($addedFileWithNode->getFilePath(), $fileContent);
                $message = sprintf('File "%s" was added', $addedFileWithNode->getFilePath());
                $this->symfonyStyle->note($message);
            }
        }
    }
}
