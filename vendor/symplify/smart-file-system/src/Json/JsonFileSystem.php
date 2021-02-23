<?php

declare (strict_types=1);
namespace RectorPrefix20210223\Symplify\SmartFileSystem\Json;

use RectorPrefix20210223\Nette\Utils\Arrays;
use RectorPrefix20210223\Nette\Utils\Json;
use RectorPrefix20210223\Symplify\SmartFileSystem\FileSystemGuard;
use RectorPrefix20210223\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @see \Symplify\SmartFileSystem\Tests\Json\JsonFileSystem\JsonFileSystemTest
 */
final class JsonFileSystem
{
    /**
     * @var FileSystemGuard
     */
    private $fileSystemGuard;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\RectorPrefix20210223\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard, \RectorPrefix20210223\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->fileSystemGuard = $fileSystemGuard;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @return mixed[]
     */
    public function loadFilePathToJson(string $filePath) : array
    {
        $this->fileSystemGuard->ensureFileExists($filePath, __METHOD__);
        $fileContent = $this->smartFileSystem->readFile($filePath);
        return \RectorPrefix20210223\Nette\Utils\Json::decode($fileContent, \RectorPrefix20210223\Nette\Utils\Json::FORCE_ARRAY);
    }
    public function writeJsonToFilePath(array $jsonArray, string $filePath) : void
    {
        $jsonContent = \RectorPrefix20210223\Nette\Utils\Json::encode($jsonArray, \RectorPrefix20210223\Nette\Utils\Json::PRETTY) . \PHP_EOL;
        $this->smartFileSystem->dumpFile($filePath, $jsonContent);
    }
    public function mergeArrayToJsonFile(string $filePath, array $newJsonArray) : void
    {
        $jsonArray = $this->loadFilePathToJson($filePath);
        $newComposerJsonArray = \RectorPrefix20210223\Nette\Utils\Arrays::mergeTree($jsonArray, $newJsonArray);
        $this->writeJsonToFilePath($newComposerJsonArray, $filePath);
    }
}
