<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\FileSystem;

use _PhpScoper0a6b37af0871\Nette\Utils\Json;
use _PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\Json\JsonCleaner;
use _PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\Json\JsonInliner;
use _PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Configuration\StaticEolConfiguration;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @see \Symplify\MonorepoBuilder\Tests\FileSystem\JsonFileManager\JsonFileManagerTest
 */
final class JsonFileManager
{
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var JsonCleaner
     */
    private $jsonCleaner;
    /**
     * @var JsonInliner
     */
    private $jsonInliner;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\Json\JsonCleaner $jsonCleaner, \_PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\Json\JsonInliner $jsonInliner)
    {
        $this->smartFileSystem = $smartFileSystem;
        $this->jsonCleaner = $jsonCleaner;
        $this->jsonInliner = $jsonInliner;
    }
    /**
     * @return mixed[]
     */
    public function loadFromFileInfo(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : array
    {
        return \_PhpScoper0a6b37af0871\Nette\Utils\Json::decode($smartFileInfo->getContents(), \_PhpScoper0a6b37af0871\Nette\Utils\Json::FORCE_ARRAY);
    }
    /**
     * @return mixed[]
     */
    public function loadFromFilePath(string $filePath) : array
    {
        $fileContent = $this->smartFileSystem->readFile($filePath);
        return \_PhpScoper0a6b37af0871\Nette\Utils\Json::decode($fileContent, \_PhpScoper0a6b37af0871\Nette\Utils\Json::FORCE_ARRAY);
    }
    /**
     * @param mixed[] $json
     */
    public function printJsonToFileInfo(array $json, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        $jsonString = $this->encodeJsonToFileContent($json);
        $this->smartFileSystem->dumpFile($smartFileInfo->getPathname(), $jsonString);
        return $jsonString;
    }
    public function printComposerJsonToFilePath(\_PhpScoper0a6b37af0871\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, string $filePath) : string
    {
        $jsonString = $this->encodeJsonToFileContent($composerJson->getJsonArray());
        $this->smartFileSystem->dumpFile($filePath, $jsonString);
        return $jsonString;
    }
    /**
     * @param mixed[] $json
     */
    public function encodeJsonToFileContent(array $json) : string
    {
        // Empty arrays may lead to bad encoding since we can't be sure whether they need to be arrays or objects.
        $json = $this->jsonCleaner->removeEmptyKeysFromJsonArray($json);
        $jsonContent = \_PhpScoper0a6b37af0871\Nette\Utils\Json::encode($json, \_PhpScoper0a6b37af0871\Nette\Utils\Json::PRETTY) . \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Configuration\StaticEolConfiguration::getEolChar();
        return $this->jsonInliner->inlineSections($jsonContent);
    }
}
