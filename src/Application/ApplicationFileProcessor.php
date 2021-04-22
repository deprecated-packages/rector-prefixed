<?php

declare (strict_types=1);
namespace Rector\Core\Application;

use Rector\Core\Application\FileDecorator\FileDiffFileDecorator;
use Rector\Core\Configuration\Configuration;
use Rector\Core\Contract\Processor\FileProcessorInterface;
use Rector\Core\ValueObject\Application\File;
use RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileSystem;
final class ApplicationFileProcessor
{
    /**
     * @var FileProcessorInterface[]
     */
    private $fileProcessors = [];
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var FileDiffFileDecorator
     */
    private $fileDiffFileDecorator;
    /**
     * @param FileProcessorInterface[] $fileProcessors
     */
    public function __construct(\Rector\Core\Configuration\Configuration $configuration, \RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Rector\Core\Application\FileDecorator\FileDiffFileDecorator $fileDiffFileDecorator, array $fileProcessors = [])
    {
        $this->fileProcessors = $fileProcessors;
        $this->smartFileSystem = $smartFileSystem;
        $this->configuration = $configuration;
        $this->fileDiffFileDecorator = $fileDiffFileDecorator;
    }
    /**
     * @param File[] $files
     * @return void
     */
    public function run(array $files)
    {
        $this->processFiles($files);
        $this->fileDiffFileDecorator->decorate($files);
        $this->printFiles($files);
    }
    /**
     * @param File[] $files
     * @return void
     */
    private function processFiles(array $files)
    {
        foreach ($this->fileProcessors as $fileProcessor) {
            $supportedFiles = \array_filter($files, function (\Rector\Core\ValueObject\Application\File $file) use($fileProcessor) : bool {
                return $fileProcessor->supports($file);
            });
            $fileProcessor->process($supportedFiles);
        }
    }
    /**
     * @param File[] $files
     * @return void
     */
    private function printFiles(array $files)
    {
        if ($this->configuration->isDryRun()) {
            return;
        }
        foreach ($files as $file) {
            if (!$file->hasChanged()) {
                continue;
            }
            $this->printFile($file);
        }
    }
    /**
     * @return void
     */
    private function printFile(\Rector\Core\ValueObject\Application\File $file)
    {
        $smartFileInfo = $file->getSmartFileInfo();
        $this->smartFileSystem->dumpFile($smartFileInfo->getPathname(), $file->getFileContent());
        $this->smartFileSystem->chmod($smartFileInfo->getRealPath(), $smartFileInfo->getPerms());
    }
}
