<?php

declare (strict_types=1);
namespace Rector\Core\Application\FileProcessor;

use PHPStan\AnalysedCodeException;
use Rector\ChangesReporting\Application\ErrorAndDiffCollector;
use Rector\Core\Application\FileDecorator\FileDiffFileDecorator;
use Rector\Core\Application\FileProcessor;
use Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use Rector\Core\Application\FileSystem\RemovedAndAddedFilesProcessor;
use Rector\Core\Configuration\Configuration;
use Rector\Core\Contract\Processor\FileProcessorInterface;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\ValueObject\Application\File;
use RectorPrefix20210412\Symfony\Component\Console\Helper\ProgressBar;
use RectorPrefix20210412\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210412\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use Throwable;
final class PhpFileProcessor implements \Rector\Core\Contract\Processor\FileProcessorInterface
{
    /**
     * Why 4? One for each cycle, so user sees some activity all the time:
     *
     * 1) parsing files
     * 2) main rectoring
     * 3) post-rectoring (removing files, importing names)
     * 4) printing
     *
     * @var int
     */
    private const PROGRESS_BAR_STEP_MULTIPLIER = 4;
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var File[]
     */
    private $notParsedFiles = [];
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var ErrorAndDiffCollector
     */
    private $errorAndDiffCollector;
    /**
     * @var FileProcessor
     */
    private $fileProcessor;
    /**
     * @var RemovedAndAddedFilesCollector
     */
    private $removedAndAddedFilesCollector;
    /**
     * @var RemovedAndAddedFilesProcessor
     */
    private $removedAndAddedFilesProcessor;
    /**
     * @var PrivatesAccessor
     */
    private $privatesAccessor;
    /**
     * @var FileDiffFileDecorator
     */
    private $fileDiffFileDecorator;
    public function __construct(\Rector\Core\Configuration\Configuration $configuration, \Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector, \Rector\Core\Application\FileProcessor $fileProcessor, \Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector $removedAndAddedFilesCollector, \Rector\Core\Application\FileSystem\RemovedAndAddedFilesProcessor $removedAndAddedFilesProcessor, \RectorPrefix20210412\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \RectorPrefix20210412\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor, \Rector\Core\Application\FileDecorator\FileDiffFileDecorator $fileDiffFileDecorator)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->errorAndDiffCollector = $errorAndDiffCollector;
        $this->configuration = $configuration;
        $this->fileProcessor = $fileProcessor;
        $this->removedAndAddedFilesCollector = $removedAndAddedFilesCollector;
        $this->removedAndAddedFilesProcessor = $removedAndAddedFilesProcessor;
        $this->privatesAccessor = $privatesAccessor;
        $this->fileDiffFileDecorator = $fileDiffFileDecorator;
        $this->configuration = $configuration;
    }
    /**
     * @param File[] $files
     */
    public function process(array $files) : void
    {
        $fileCount = \count($files);
        if ($fileCount === 0) {
            return;
        }
        $this->prepareProgressBar($fileCount);
        // 1. parse files to nodes
        $this->parseFileInfosToNodes($files);
        // 2. change nodes with Rectors
        $this->refactorNodesWithRectors($files);
        // 3. apply post rectors
        foreach ($files as $file) {
            $this->tryCatchWrapper($file, function (\Rector\Core\ValueObject\Application\File $file) : void {
                $this->fileProcessor->postFileRefactor($file);
            }, 'post rectors');
        }
        // 4. print to file or string
        foreach ($files as $file) {
            // cannot print file with errors, as print would break everything to original nodes
            if ($this->errorAndDiffCollector->hasSmartFileErrors($file)) {
                $this->advance($file, 'printing skipped due error');
                continue;
            }
            $this->tryCatchWrapper($file, function (\Rector\Core\ValueObject\Application\File $file) : void {
                $this->printFileInfo($file);
            }, 'printing');
        }
        if ($this->configuration->shouldShowProgressBar()) {
            $this->symfonyStyle->newLine(2);
        }
        // 4. remove and add files
        $this->removedAndAddedFilesProcessor->run();
    }
    public function supports(\Rector\Core\ValueObject\Application\File $file) : bool
    {
        $fileInfo = $file->getSmartFileInfo();
        return $fileInfo->hasSuffixes($this->getSupportedFileExtensions());
    }
    /**
     * @return string[]
     */
    public function getSupportedFileExtensions() : array
    {
        return $this->configuration->getFileExtensions();
    }
    private function prepareProgressBar(int $fileCount) : void
    {
        if ($this->symfonyStyle->isVerbose()) {
            return;
        }
        if (!$this->configuration->shouldShowProgressBar()) {
            return;
        }
        $this->configureStepCount($fileCount);
    }
    /**
     * @param File[] $files
     */
    private function parseFileInfosToNodes(array $files) : void
    {
        foreach ($files as $file) {
            $this->tryCatchWrapper($file, function (\Rector\Core\ValueObject\Application\File $file) : void {
                $this->fileProcessor->parseFileInfoToLocalCache($file);
            }, 'parsing');
        }
    }
    /**
     * @param File[] $files
     */
    private function refactorNodesWithRectors(array $files) : void
    {
        foreach ($files as $file) {
            $this->tryCatchWrapper($file, function (\Rector\Core\ValueObject\Application\File $file) : void {
                $this->fileProcessor->refactor($file);
            }, 'refactoring');
        }
    }
    private function tryCatchWrapper(\Rector\Core\ValueObject\Application\File $file, callable $callback, string $phase) : void
    {
        $this->advance($file, $phase);
        try {
            if (\in_array($file, $this->notParsedFiles, \true)) {
                // we cannot process this file
                return;
            }
            $callback($file);
        } catch (\PHPStan\AnalysedCodeException $analysedCodeException) {
            $this->notParsedFiles[] = $file;
            $this->errorAndDiffCollector->addAutoloadError($analysedCodeException, $file);
        } catch (\Throwable $throwable) {
            if ($this->symfonyStyle->isVerbose()) {
                throw $throwable;
            }
            $fileInfo = $file->getSmartFileInfo();
            $this->errorAndDiffCollector->addThrowableWithFileInfo($throwable, $fileInfo);
        }
    }
    private function printFileInfo(\Rector\Core\ValueObject\Application\File $file) : void
    {
        $fileInfo = $file->getSmartFileInfo();
        if ($this->removedAndAddedFilesCollector->isFileRemoved($fileInfo)) {
            // skip, because this file exists no more
            return;
        }
        $newContent = $this->configuration->isDryRun() ? $this->fileProcessor->printToString($fileInfo) : $this->fileProcessor->printToFile($fileInfo);
        $file->changeFileContent($newContent);
        $this->fileDiffFileDecorator->decorate([$file]);
    }
    /**
     * This prevent CI report flood with 1 file = 1 line in progress bar
     */
    private function configureStepCount(int $fileCount) : void
    {
        $this->symfonyStyle->progressStart($fileCount * self::PROGRESS_BAR_STEP_MULTIPLIER);
        $progressBar = $this->privatesAccessor->getPrivateProperty($this->symfonyStyle, 'progressBar');
        if (!$progressBar instanceof \RectorPrefix20210412\Symfony\Component\Console\Helper\ProgressBar) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        if ($progressBar->getMaxSteps() < 40) {
            return;
        }
        $redrawFrequency = (int) ($progressBar->getMaxSteps() / 20);
        $progressBar->setRedrawFrequency($redrawFrequency);
    }
    private function advance(\Rector\Core\ValueObject\Application\File $file, string $phase) : void
    {
        if ($this->symfonyStyle->isVerbose()) {
            $fileInfo = $file->getSmartFileInfo();
            $relativeFilePath = $fileInfo->getRelativeFilePathFromDirectory(\getcwd());
            $message = \sprintf('[%s] %s', $phase, $relativeFilePath);
            $this->symfonyStyle->writeln($message);
        } elseif ($this->configuration->shouldShowProgressBar()) {
            $this->symfonyStyle->progressAdvance();
        }
    }
}