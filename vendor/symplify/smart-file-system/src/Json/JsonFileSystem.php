<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\Json;

use _PhpScoper0a6b37af0871\Nette\Utils\Arrays;
use _PhpScoper0a6b37af0871\Nette\Utils\Json;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemGuard;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->fileSystemGuard = $fileSystemGuard;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function loadFilePathToJson(string $filePath) : array
    {
        $this->fileSystemGuard->ensureFileExists($filePath, __METHOD__);
        $fileContent = $this->smartFileSystem->readFile($filePath);
        return \_PhpScoper0a6b37af0871\Nette\Utils\Json::decode($fileContent, \_PhpScoper0a6b37af0871\Nette\Utils\Json::FORCE_ARRAY);
    }
    public function writeJsonToFilePath(array $jsonArray, string $filePath) : void
    {
        $jsonContent = \_PhpScoper0a6b37af0871\Nette\Utils\Json::encode($jsonArray, \_PhpScoper0a6b37af0871\Nette\Utils\Json::PRETTY) . \PHP_EOL;
        $this->smartFileSystem->dumpFile($filePath, $jsonContent);
    }
    public function mergeArrayToJsonFile(string $filePath, array $newJsonArray) : void
    {
        $jsonArray = $this->loadFilePathToJson($filePath);
        $newComposerJsonArray = \_PhpScoper0a6b37af0871\Nette\Utils\Arrays::mergeTree($jsonArray, $newJsonArray);
        $this->writeJsonToFilePath($newComposerJsonArray, $filePath);
    }
}
