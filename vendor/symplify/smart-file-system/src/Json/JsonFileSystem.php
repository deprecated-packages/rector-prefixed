<?php

declare (strict_types=1);
namespace Symplify\SmartFileSystem\Json;

use RectorPrefix2020DecSat\Nette\Utils\Arrays;
use RectorPrefix2020DecSat\Nette\Utils\Json;
use Symplify\SmartFileSystem\FileSystemGuard;
use Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard, \Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->fileSystemGuard = $fileSystemGuard;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function loadFilePathToJson(string $filePath) : array
    {
        $this->fileSystemGuard->ensureFileExists($filePath, __METHOD__);
        $fileContent = $this->smartFileSystem->readFile($filePath);
        return \RectorPrefix2020DecSat\Nette\Utils\Json::decode($fileContent, \RectorPrefix2020DecSat\Nette\Utils\Json::FORCE_ARRAY);
    }
    public function writeJsonToFilePath(array $jsonArray, string $filePath) : void
    {
        $jsonContent = \RectorPrefix2020DecSat\Nette\Utils\Json::encode($jsonArray, \RectorPrefix2020DecSat\Nette\Utils\Json::PRETTY) . \PHP_EOL;
        $this->smartFileSystem->dumpFile($filePath, $jsonContent);
    }
    public function mergeArrayToJsonFile(string $filePath, array $newJsonArray) : void
    {
        $jsonArray = $this->loadFilePathToJson($filePath);
        $newComposerJsonArray = \RectorPrefix2020DecSat\Nette\Utils\Arrays::mergeTree($jsonArray, $newJsonArray);
        $this->writeJsonToFilePath($newComposerJsonArray, $filePath);
    }
}
