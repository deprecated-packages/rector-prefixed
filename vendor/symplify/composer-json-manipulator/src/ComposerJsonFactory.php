<?php

declare (strict_types=1);
namespace Symplify\ComposerJsonManipulator;

use Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\ComposerJsonManipulator\Tests\ComposerJsonFactory\ComposerJsonFactoryTest
 */
final class ComposerJsonFactory
{
    /**
     * @var JsonFileManager
     */
    private $jsonFileManager;
    public function __construct(\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager $jsonFileManager)
    {
        $this->jsonFileManager = $jsonFileManager;
    }
    public function createFromFileInfo(\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \Symplify\ComposerJsonManipulator\ValueObject\ComposerJson
    {
        $jsonArray = $this->jsonFileManager->loadFromFilePath($smartFileInfo->getRealPath());
        $composerJson = $this->createFromArray($jsonArray);
        $composerJson->setOriginalFileInfo($smartFileInfo);
        return $composerJson;
    }
    public function createFromFilePath(string $filePath) : \Symplify\ComposerJsonManipulator\ValueObject\ComposerJson
    {
        $jsonArray = $this->jsonFileManager->loadFromFilePath($filePath);
        $composerJson = $this->createFromArray($jsonArray);
        $fileInfo = new \Symplify\SmartFileSystem\SmartFileInfo($filePath);
        $composerJson->setOriginalFileInfo($fileInfo);
        return $composerJson;
    }
    public function createEmpty() : \Symplify\ComposerJsonManipulator\ValueObject\ComposerJson
    {
        return new \Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
    }
    /**
     * @param mixed[] $jsonArray
     */
    public function createFromArray(array $jsonArray) : \Symplify\ComposerJsonManipulator\ValueObject\ComposerJson
    {
        $composerJson = new \Symplify\ComposerJsonManipulator\ValueObject\ComposerJson();
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::NAME])) {
            $composerJson->setName($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::NAME]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::TYPE])) {
            $composerJson->setType($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::TYPE]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::AUTHORS])) {
            $composerJson->setAuthors($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::AUTHORS]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::DESCRIPTION])) {
            $composerJson->setDescription($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::DESCRIPTION]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::LICENSE])) {
            $composerJson->setLicense($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::LICENSE]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::BIN])) {
            $composerJson->setBin($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::BIN]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REQUIRE])) {
            $composerJson->setRequire($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REQUIRE]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REQUIRE_DEV])) {
            $composerJson->setRequireDev($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REQUIRE_DEV]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::AUTOLOAD])) {
            $composerJson->setAutoload($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::AUTOLOAD]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::AUTOLOAD_DEV])) {
            $composerJson->setAutoloadDev($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::AUTOLOAD_DEV]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REPLACE])) {
            $composerJson->setReplace($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REPLACE]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::CONFIG])) {
            $composerJson->setConfig($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::CONFIG]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::EXTRA])) {
            $composerJson->setExtra($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::EXTRA]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::SCRIPTS])) {
            $composerJson->setScripts($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::SCRIPTS]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::MINIMUM_STABILITY])) {
            $composerJson->setMinimumStability($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::MINIMUM_STABILITY]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::PREFER_STABLE])) {
            $composerJson->setPreferStable($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::PREFER_STABLE]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::CONFLICTING])) {
            $composerJson->setConflicting($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::CONFLICTING]);
        }
        if (isset($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REPOSITORIES])) {
            $composerJson->setRepositories($jsonArray[\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REPOSITORIES]);
        }
        $orderedKeys = \array_keys($jsonArray);
        $composerJson->setOrderedKeys($orderedKeys);
        return $composerJson;
    }
}
