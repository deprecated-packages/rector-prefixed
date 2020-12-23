<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\Json;

use _PhpScoper0a2ac50786fa\Nette\Utils\Arrays;
use _PhpScoper0a2ac50786fa\Nette\Utils\Json;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\FileSystemGuard;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->fileSystemGuard = $fileSystemGuard;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function loadFilePathToJson(string $filePath) : array
    {
        $this->fileSystemGuard->ensureFileExists($filePath, __METHOD__);
        $fileContent = $this->smartFileSystem->readFile($filePath);
        return \_PhpScoper0a2ac50786fa\Nette\Utils\Json::decode($fileContent, \_PhpScoper0a2ac50786fa\Nette\Utils\Json::FORCE_ARRAY);
    }
    public function writeJsonToFilePath(array $jsonArray, string $filePath) : void
    {
        $jsonContent = \_PhpScoper0a2ac50786fa\Nette\Utils\Json::encode($jsonArray, \_PhpScoper0a2ac50786fa\Nette\Utils\Json::PRETTY) . \PHP_EOL;
        $this->smartFileSystem->dumpFile($filePath, $jsonContent);
    }
    public function mergeArrayToJsonFile(string $filePath, array $newJsonArray) : void
    {
        $jsonArray = $this->loadFilePathToJson($filePath);
        $newComposerJsonArray = \_PhpScoper0a2ac50786fa\Nette\Utils\Arrays::mergeTree($jsonArray, $newJsonArray);
        $this->writeJsonToFilePath($newComposerJsonArray, $filePath);
    }
}
