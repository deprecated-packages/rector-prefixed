<?php

declare (strict_types=1);
namespace Symplify\ComposerJsonManipulator\Printer;

use Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class ComposerJsonPrinter
{
    /**
     * @var JsonFileManager
     */
    private $jsonFileManager;
    public function __construct(\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager $jsonFileManager)
    {
        $this->jsonFileManager = $jsonFileManager;
    }
    public function printToString(\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : string
    {
        return $this->jsonFileManager->encodeJsonToFileContent($composerJson->getJsonArray());
    }
    /**
     * @param string|SmartFileInfo $targetFile
     */
    public function print(\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, $targetFile) : string
    {
        if (\is_string($targetFile)) {
            return $this->jsonFileManager->printComposerJsonToFilePath($composerJson, $targetFile);
        }
        if (!$targetFile instanceof \Symplify\SmartFileSystem\SmartFileInfo) {
            throw new \Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->jsonFileManager->printJsonToFileInfo($composerJson->getJsonArray(), $targetFile);
    }
}
