<?php

declare (strict_types=1);
namespace Rector\Composer\Processor;

use Rector\ChangesReporting\Application\ErrorAndDiffCollector;
use Rector\Composer\Modifier\ComposerModifier;
use Rector\Core\Configuration\Configuration;
use RectorPrefix20210113\Symfony\Component\Process\Process;
use RectorPrefix20210113\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use RectorPrefix20210113\Symplify\ComposerJsonManipulator\Printer\ComposerJsonPrinter;
use RectorPrefix20210113\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210113\Symplify\SmartFileSystem\SmartFileSystem;
final class ComposerProcessor
{
    /** @var ComposerJsonFactory */
    private $composerJsonFactory;
    /** @var ComposerJsonPrinter */
    private $composerJsonPrinter;
    /** @var ComposerModifier */
    private $composerModifier;
    /** @var Configuration */
    private $configuration;
    /** @var SmartFileSystem */
    private $smartFileSystem;
    /** @var ErrorAndDiffCollector */
    private $errorAndDiffCollector;
    public function __construct(\RectorPrefix20210113\Symplify\ComposerJsonManipulator\ComposerJsonFactory $composerJsonFactory, \RectorPrefix20210113\Symplify\ComposerJsonManipulator\Printer\ComposerJsonPrinter $composerJsonPrinter, \Rector\Composer\Modifier\ComposerModifier $composerModifier, \Rector\Core\Configuration\Configuration $configuration, \RectorPrefix20210113\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector)
    {
        $this->composerJsonFactory = $composerJsonFactory;
        $this->composerJsonPrinter = $composerJsonPrinter;
        $this->composerModifier = $composerModifier;
        $this->configuration = $configuration;
        $this->smartFileSystem = $smartFileSystem;
        $this->errorAndDiffCollector = $errorAndDiffCollector;
    }
    public function process() : void
    {
        $smartFileInfo = new \RectorPrefix20210113\Symplify\SmartFileSystem\SmartFileInfo($this->composerModifier->getFilePath());
        $composerJson = $this->composerJsonFactory->createFromFileInfo($smartFileInfo);
        $oldContents = $smartFileInfo->getContents();
        $newComposerJson = $this->composerModifier->modify($composerJson);
        $newContents = $this->composerJsonPrinter->printToString($newComposerJson);
        // nothing has changed
        if ($oldContents === $newContents) {
            return;
        }
        $this->errorAndDiffCollector->addFileDiff($smartFileInfo, $newContents, $oldContents);
        $this->reportFileContentChange($smartFileInfo, $newContents);
    }
    private function reportFileContentChange(\RectorPrefix20210113\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $newContent) : void
    {
        if ($this->configuration->isDryRun()) {
            return;
        }
        $this->smartFileSystem->dumpFile($smartFileInfo->getRealPath(), $newContent);
        $this->smartFileSystem->chmod($smartFileInfo->getRealPath(), $smartFileInfo->getPerms());
        $command = $this->composerModifier->getCommand();
        $process = new \RectorPrefix20210113\Symfony\Component\Process\Process(\explode(' ', $command), \getcwd());
        $process->run(function (string $type, string $message) : void {
            // $type is always err https://github.com/composer/composer/issues/3795#issuecomment-76401013
            echo $message;
        });
    }
}
