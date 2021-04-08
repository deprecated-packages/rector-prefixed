<?php

declare (strict_types=1);
namespace Rector\Composer\Processor;

use Rector\ChangesReporting\Application\ErrorAndDiffCollector;
use Rector\Composer\Modifier\ComposerModifier;
use Rector\Core\Configuration\Configuration;
use RectorPrefix20210408\Symfony\Component\Process\Process;
use RectorPrefix20210408\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use RectorPrefix20210408\Symplify\ComposerJsonManipulator\Printer\ComposerJsonPrinter;
use RectorPrefix20210408\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem;
final class ComposerProcessor
{
    /**
     * @var string
     */
    private const COMPOSER_UPDATE = 'composer update';
    /**
     * @var ComposerJsonFactory
     */
    private $composerJsonFactory;
    /**
     * @var ComposerJsonPrinter
     */
    private $composerJsonPrinter;
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var ErrorAndDiffCollector
     */
    private $errorAndDiffCollector;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var ComposerModifier
     */
    private $composerModifier;
    public function __construct(\RectorPrefix20210408\Symplify\ComposerJsonManipulator\ComposerJsonFactory $composerJsonFactory, \RectorPrefix20210408\Symplify\ComposerJsonManipulator\Printer\ComposerJsonPrinter $composerJsonPrinter, \Rector\Core\Configuration\Configuration $configuration, \Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector, \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Rector\Composer\Modifier\ComposerModifier $composerModifier)
    {
        $this->composerJsonFactory = $composerJsonFactory;
        $this->composerJsonPrinter = $composerJsonPrinter;
        $this->configuration = $configuration;
        $this->errorAndDiffCollector = $errorAndDiffCollector;
        $this->smartFileSystem = $smartFileSystem;
        $this->composerModifier = $composerModifier;
    }
    public function process(string $composerJsonFilePath) : void
    {
        if (!$this->smartFileSystem->exists($composerJsonFilePath)) {
            return;
        }
        // to avoid modification of file
        if (!$this->composerModifier->enabled()) {
            return;
        }
        $smartFileInfo = new \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo($composerJsonFilePath);
        $composerJson = $this->composerJsonFactory->createFromFileInfo($smartFileInfo);
        $oldComposerJson = clone $composerJson;
        $this->composerModifier->modify($composerJson);
        // nothing has changed
        if ($oldComposerJson->getJsonArray() === $composerJson->getJsonArray()) {
            return;
        }
        $this->addComposerJsonFileDiff($oldComposerJson, $composerJson, $smartFileInfo);
        $this->reportFileContentChange($composerJson, $smartFileInfo);
    }
    private function addComposerJsonFileDiff(\RectorPrefix20210408\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $oldComposerJson, \RectorPrefix20210408\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $newComposerJson, \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $newContents = $this->composerJsonPrinter->printToString($newComposerJson);
        $oldContents = $this->composerJsonPrinter->printToString($oldComposerJson);
        $this->errorAndDiffCollector->addFileDiff($smartFileInfo, $newContents, $oldContents);
    }
    private function reportFileContentChange(\RectorPrefix20210408\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        if ($this->configuration->isDryRun()) {
            return;
        }
        $this->composerJsonPrinter->print($composerJson, $smartFileInfo);
        $process = new \RectorPrefix20210408\Symfony\Component\Process\Process(\explode(' ', self::COMPOSER_UPDATE), \getcwd());
        $process->run(function (string $type, string $message) : void {
            // $type is always err https://github.com/composer/composer/issues/3795#issuecomment-76401013
            echo $message;
        });
    }
}
