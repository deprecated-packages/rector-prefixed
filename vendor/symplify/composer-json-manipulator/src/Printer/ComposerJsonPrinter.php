<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\ComposerJsonManipulator\Printer;

use _PhpScoper0a2ac50786fa\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use _PhpScoper0a2ac50786fa\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class ComposerJsonPrinter
{
    /**
     * @var JsonFileManager
     */
    private $jsonFileManager;
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager $jsonFileManager)
    {
        $this->jsonFileManager = $jsonFileManager;
    }
    public function printToString(\_PhpScoper0a2ac50786fa\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : string
    {
        return $this->jsonFileManager->encodeJsonToFileContent($composerJson->getJsonArray());
    }
    /**
     * @param string|SmartFileInfo $targetFile
     */
    public function print(\_PhpScoper0a2ac50786fa\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, $targetFile) : string
    {
        if (\is_string($targetFile)) {
            return $this->jsonFileManager->printComposerJsonToFilePath($composerJson, $targetFile);
        }
        if (!$targetFile instanceof \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo) {
            throw new \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->jsonFileManager->printJsonToFileInfo($composerJson->getJsonArray(), $targetFile);
    }
}
