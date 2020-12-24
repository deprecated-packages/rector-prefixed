<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator;

use _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\ComposerJsonManipulator\Tests\ComposerJsonFactory\ComposerJsonFactoryTest
 */
final class ComposerJsonFactory
{
    /**
     * @var JsonFileManager
     */
    private $jsonFileManager;
    public function __construct(\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager $jsonFileManager)
    {
        $this->jsonFileManager = $jsonFileManager;
    }
    public function createFromFileInfo(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson
    {
        $jsonArray = $this->jsonFileManager->loadFromFilePath($smartFileInfo->getRealPath());
        $composerJson = $this->createFromArray($jsonArray);
        $composerJson->setOriginalFileInfo($smartFileInfo);
        return $composerJson;
    }
    public function createFromFilePath(string $filePath) : \_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson
    {
        $jsonArray = $this->jsonFileManager->loadFromFilePath($filePath);
        $composerJson = $this->createFromArray($jsonArray);
        $fileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($filePath);
        $composerJson->setOriginalFileInfo($fileInfo);
        return $composerJson;
    }
    public function createEmpty() : \_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson
    {
        return new \_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
    }
    /**
     * @param mixed[] $jsonArray
     */
    public function createFromArray(array $jsonArray) : \_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson
    {
        $composerJson = new \_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::NAME])) {
            $composerJson->setName($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::NAME]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::TYPE])) {
            $composerJson->setType($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::TYPE]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::AUTHORS])) {
            $composerJson->setAuthors($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::AUTHORS]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::DESCRIPTION])) {
            $composerJson->setDescription($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::DESCRIPTION]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::LICENSE])) {
            $composerJson->setLicense($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::LICENSE]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::BIN])) {
            $composerJson->setBin($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::BIN]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REQUIRE])) {
            $composerJson->setRequire($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REQUIRE]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REQUIRE_DEV])) {
            $composerJson->setRequireDev($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REQUIRE_DEV]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::AUTOLOAD])) {
            $composerJson->setAutoload($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::AUTOLOAD]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::AUTOLOAD_DEV])) {
            $composerJson->setAutoloadDev($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::AUTOLOAD_DEV]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REPLACE])) {
            $composerJson->setReplace($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REPLACE]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::CONFIG])) {
            $composerJson->setConfig($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::CONFIG]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::EXTRA])) {
            $composerJson->setExtra($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::EXTRA]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::SCRIPTS])) {
            $composerJson->setScripts($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::SCRIPTS]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::MINIMUM_STABILITY])) {
            $composerJson->setMinimumStability($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::MINIMUM_STABILITY]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::PREFER_STABLE])) {
            $composerJson->setPreferStable($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::PREFER_STABLE]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::CONFLICTING])) {
            $composerJson->setConflicting($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::CONFLICTING]);
        }
        if (isset($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REPOSITORIES])) {
            $composerJson->setRepositories($jsonArray[\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REPOSITORIES]);
        }
        $orderedKeys = \array_keys($jsonArray);
        $composerJson->setOrderedKeys($orderedKeys);
        return $composerJson;
    }
}
