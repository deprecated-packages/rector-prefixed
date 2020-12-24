<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\Printer;

use _PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use _PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class ComposerJsonPrinter
{
    /**
     * @var JsonFileManager
     */
    private $jsonFileManager;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager $jsonFileManager)
    {
        $this->jsonFileManager = $jsonFileManager;
    }
    public function printToString(\_PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : string
    {
        return $this->jsonFileManager->encodeJsonToFileContent($composerJson->getJsonArray());
    }
    /**
     * @param string|SmartFileInfo $targetFile
     */
    public function print(\_PhpScoper2a4e7ab1ecbc\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, $targetFile) : string
    {
        if (\is_string($targetFile)) {
            return $this->jsonFileManager->printComposerJsonToFilePath($composerJson, $targetFile);
        }
        if (!$targetFile instanceof \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo) {
            throw new \_PhpScoper2a4e7ab1ecbc\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->jsonFileManager->printJsonToFileInfo($composerJson->getJsonArray(), $targetFile);
    }
}
