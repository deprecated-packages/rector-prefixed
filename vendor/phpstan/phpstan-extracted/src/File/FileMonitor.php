<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\File;

use function array_key_exists;
class FileMonitor
{
    /** @var FileFinder */
    private $fileFinder;
    /** @var array<string, string>|null */
    private $fileHashes;
    /** @var array<string>|null */
    private $paths;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\File\FileFinder $fileFinder)
    {
        $this->fileFinder = $fileFinder;
    }
    /**
     * @param array<string> $paths
     */
    public function initialize(array $paths) : void
    {
        $finderResult = $this->fileFinder->findFiles($paths);
        $fileHashes = [];
        foreach ($finderResult->getFiles() as $filePath) {
            $fileHashes[$filePath] = $this->getFileHash($filePath);
        }
        $this->fileHashes = $fileHashes;
        $this->paths = $paths;
    }
    public function getChanges() : \_PhpScoper0a6b37af0871\PHPStan\File\FileMonitorResult
    {
        if ($this->fileHashes === null || $this->paths === null) {
            throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
        }
        $finderResult = $this->fileFinder->findFiles($this->paths);
        $oldFileHashes = $this->fileHashes;
        $fileHashes = [];
        $newFiles = [];
        $changedFiles = [];
        $deletedFiles = [];
        foreach ($finderResult->getFiles() as $filePath) {
            if (!\array_key_exists($filePath, $oldFileHashes)) {
                $newFiles[] = $filePath;
                $fileHashes[$filePath] = $this->getFileHash($filePath);
                continue;
            }
            $oldHash = $oldFileHashes[$filePath];
            unset($oldFileHashes[$filePath]);
            $newHash = $this->getFileHash($filePath);
            $fileHashes[$filePath] = $newHash;
            if ($oldHash === $newHash) {
                continue;
            }
            $changedFiles[] = $filePath;
        }
        $this->fileHashes = $fileHashes;
        foreach (\array_keys($oldFileHashes) as $file) {
            $deletedFiles[] = $file;
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\File\FileMonitorResult($newFiles, $changedFiles, $deletedFiles, \count($fileHashes));
    }
    private function getFileHash(string $filePath) : string
    {
        return \sha1(\_PhpScoper0a6b37af0871\PHPStan\File\FileReader::read($filePath));
    }
}
