<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\Printer;

use _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScopere8e811afab72\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class ComposerJsonPrinter
{
    /**
     * @var JsonFileManager
     */
    private $jsonFileManager;
    public function __construct(\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager $jsonFileManager)
    {
        $this->jsonFileManager = $jsonFileManager;
    }
    public function printToString(\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : string
    {
        return $this->jsonFileManager->encodeJsonToFileContent($composerJson->getJsonArray());
    }
    /**
     * @param string|SmartFileInfo $targetFile
     */
    public function print(\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, $targetFile) : string
    {
        if (\is_string($targetFile)) {
            return $this->jsonFileManager->printComposerJsonToFilePath($composerJson, $targetFile);
        }
        if (!$targetFile instanceof \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo) {
            throw new \_PhpScopere8e811afab72\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->jsonFileManager->printJsonToFileInfo($composerJson->getJsonArray(), $targetFile);
    }
}
