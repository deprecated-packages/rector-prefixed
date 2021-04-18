<?php

declare (strict_types=1);
namespace Rector\Composer\Application\FileProcessor;

use Rector\Composer\Modifier\ComposerModifier;
use Rector\Core\Contract\Processor\FileProcessorInterface;
use Rector\Core\ValueObject\Application\File;
use Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use RectorPrefix20210418\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use RectorPrefix20210418\Symplify\ComposerJsonManipulator\Printer\ComposerJsonPrinter;
use RectorPrefix20210418\Symplify\SmartFileSystem\SmartFileInfo;
final class ComposerFileProcessor implements \Rector\Core\Contract\Processor\FileProcessorInterface
{
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
    public function __construct(\RectorPrefix20210418\Symplify\ComposerJsonManipulator\ComposerJsonFactory $composerJsonFactory, \RectorPrefix20210418\Symplify\ComposerJsonManipulator\Printer\ComposerJsonPrinter $composerJsonPrinter, \Rector\Composer\Modifier\ComposerModifier $composerModifier)
    {
        $this->composerJsonFactory = $composerJsonFactory;
        $this->composerJsonPrinter = $composerJsonPrinter;
        $this->composerModifier = $composerModifier;
    }
    /**
     * @param File[] $files
     */
    public function process(array $files) : void
    {
        foreach ($files as $file) {
            $this->processFile($file);
        }
    }
    public function supports(\Rector\Core\ValueObject\Application\File $file) : bool
    {
        $smartFileInfo = $file->getSmartFileInfo();
        if ($this->isJsonInTests($smartFileInfo)) {
            return \true;
        }
        return $smartFileInfo->getBasename() === 'composer.json';
    }
    /**
     * @return string[]
     */
    public function getSupportedFileExtensions() : array
    {
        return ['json'];
    }
    private function processFile(\Rector\Core\ValueObject\Application\File $file) : void
    {
        // to avoid modification of file
        if (!$this->composerModifier->enabled()) {
            return;
        }
        $smartFileInfo = $file->getSmartFileInfo();
        $composerJson = $this->composerJsonFactory->createFromFileInfo($smartFileInfo);
        $oldComposerJson = clone $composerJson;
        $this->composerModifier->modify($composerJson);
        // nothing has changed
        if ($oldComposerJson->getJsonArray() === $composerJson->getJsonArray()) {
            return;
        }
        $changeFileContent = $this->composerJsonPrinter->printToString($composerJson);
        $file->changeFileContent($changeFileContent);
    }
    private function isJsonInTests(\RectorPrefix20210418\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : bool
    {
        if (!\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            return \false;
        }
        return $fileInfo->hasSuffixes(['json']);
    }
}
