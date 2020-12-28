<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\ComposerJsonManipulator\Printer;

use RectorPrefix20201228\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use RectorPrefix20201228\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20201228\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class ComposerJsonPrinter
{
    /**
     * @var JsonFileManager
     */
    private $jsonFileManager;
    public function __construct(\RectorPrefix20201228\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager $jsonFileManager)
    {
        $this->jsonFileManager = $jsonFileManager;
    }
    public function printToString(\RectorPrefix20201228\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : string
    {
        return $this->jsonFileManager->encodeJsonToFileContent($composerJson->getJsonArray());
    }
    /**
     * @param string|SmartFileInfo $targetFile
     */
    public function print(\RectorPrefix20201228\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, $targetFile) : string
    {
        if (\is_string($targetFile)) {
            return $this->jsonFileManager->printComposerJsonToFilePath($composerJson, $targetFile);
        }
        if (!$targetFile instanceof \RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo) {
            throw new \RectorPrefix20201228\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->jsonFileManager->printJsonToFileInfo($composerJson->getJsonArray(), $targetFile);
    }
}
