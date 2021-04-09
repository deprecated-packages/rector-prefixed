<?php

declare (strict_types=1);
namespace Rector\Composer\Processor;

use Rector\Composer\Modifier\ComposerModifier;
use Rector\Core\Configuration\Configuration;
use Rector\Core\Contract\Processor\NonPhpFileProcessorInterface;
use Rector\Core\ValueObject\NonPhpFile\NonPhpFileChange;
use RectorPrefix20210409\Symfony\Component\Process\Process;
use RectorPrefix20210409\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use RectorPrefix20210409\Symplify\ComposerJsonManipulator\Printer\ComposerJsonPrinter;
use RectorPrefix20210409\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use RectorPrefix20210409\Symplify\SmartFileSystem\SmartFileInfo;
final class ComposerProcessorNonPhp implements \Rector\Core\Contract\Processor\NonPhpFileProcessorInterface
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
     * @var ComposerModifier
     */
    private $composerModifier;
    /**
     * @var Configuration
     */
    private $configuration;
    public function __construct(\RectorPrefix20210409\Symplify\ComposerJsonManipulator\ComposerJsonFactory $composerJsonFactory, \RectorPrefix20210409\Symplify\ComposerJsonManipulator\Printer\ComposerJsonPrinter $composerJsonPrinter, \Rector\Core\Configuration\Configuration $configuration, \Rector\Composer\Modifier\ComposerModifier $composerModifier)
    {
        $this->composerJsonFactory = $composerJsonFactory;
        $this->composerJsonPrinter = $composerJsonPrinter;
        $this->configuration = $configuration;
        $this->composerModifier = $composerModifier;
    }
    public function process(\RectorPrefix20210409\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : ?\Rector\Core\ValueObject\NonPhpFile\NonPhpFileChange
    {
        // to avoid modification of file
        if (!$this->composerModifier->enabled()) {
            return null;
        }
        $composerJson = $this->composerJsonFactory->createFromFileInfo($smartFileInfo);
        $oldComposerJson = clone $composerJson;
        $this->composerModifier->modify($composerJson);
        // nothing has changed
        if ($oldComposerJson->getJsonArray() === $composerJson->getJsonArray()) {
            return null;
        }
        $oldContent = $this->composerJsonPrinter->printToString($oldComposerJson);
        $newContent = $this->composerJsonPrinter->printToString($composerJson);
        $this->reportFileContentChange($composerJson, $smartFileInfo);
        return new \Rector\Core\ValueObject\NonPhpFile\NonPhpFileChange($oldContent, $newContent);
    }
    public function supports(\RectorPrefix20210409\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        return $smartFileInfo->getRealPath() === \getcwd() . '/composer.json';
    }
    public function getSupportedFileExtensions() : array
    {
        return ['json'];
    }
    private function reportFileContentChange(\RectorPrefix20210409\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, \RectorPrefix20210409\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        if ($this->configuration->isDryRun()) {
            return;
        }
        $this->composerJsonPrinter->print($composerJson, $smartFileInfo);
        $process = new \RectorPrefix20210409\Symfony\Component\Process\Process(\explode(' ', self::COMPOSER_UPDATE), \getcwd());
        $process->run(function (string $type, string $message) : void {
            // $type is always err https://github.com/composer/composer/issues/3795#issuecomment-76401013
            echo $message;
        });
    }
}
