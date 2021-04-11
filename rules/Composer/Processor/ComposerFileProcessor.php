<?php

declare (strict_types=1);
namespace Rector\Composer\Processor;

use Rector\Composer\Modifier\ComposerModifier;
use Rector\Core\Contract\Processor\FileProcessorInterface;
use Rector\Core\ValueObject\NonPhpFile\NonPhpFileChange;
use RectorPrefix20210411\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use RectorPrefix20210411\Symplify\ComposerJsonManipulator\Printer\ComposerJsonPrinter;
use RectorPrefix20210411\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\RectorPrefix20210411\Symplify\ComposerJsonManipulator\ComposerJsonFactory $composerJsonFactory, \RectorPrefix20210411\Symplify\ComposerJsonManipulator\Printer\ComposerJsonPrinter $composerJsonPrinter, \Rector\Composer\Modifier\ComposerModifier $composerModifier)
    {
        $this->composerJsonFactory = $composerJsonFactory;
        $this->composerJsonPrinter = $composerJsonPrinter;
        $this->composerModifier = $composerModifier;
    }
    public function process(\RectorPrefix20210411\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : ?\Rector\Core\ValueObject\NonPhpFile\NonPhpFileChange
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
        return new \Rector\Core\ValueObject\NonPhpFile\NonPhpFileChange($oldContent, $newContent);
    }
    public function supports(\RectorPrefix20210411\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        return $smartFileInfo->getRealPath() === \getcwd() . '/composer.json';
    }
    /**
     * @return string[]
     */
    public function getSupportedFileExtensions() : array
    {
        return ['json'];
    }
}
