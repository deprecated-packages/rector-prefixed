<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\Printer;

use _PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use _PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class ComposerJsonPrinter
{
    /**
     * @var JsonFileManager
     */
    private $jsonFileManager;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager $jsonFileManager)
    {
        $this->jsonFileManager = $jsonFileManager;
    }
    public function printToString(\_PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : string
    {
        return $this->jsonFileManager->encodeJsonToFileContent($composerJson->getJsonArray());
    }
    /**
     * @param string|SmartFileInfo $targetFile
     */
    public function print(\_PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, $targetFile) : string
    {
        if (\is_string($targetFile)) {
            return $this->jsonFileManager->printComposerJsonToFilePath($composerJson, $targetFile);
        }
        if (!$targetFile instanceof \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo) {
            throw new \_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->jsonFileManager->printJsonToFileInfo($composerJson->getJsonArray(), $targetFile);
    }
}
