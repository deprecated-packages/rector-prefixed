<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Caching\Detector;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\Rector\Caching\Config\FileHashComputer;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Inspired by https://github.com/symplify/symplify/pull/90/files#diff-72041b2e1029a08930e13d79d298ef11
 * @see \Rector\Caching\Tests\Detector\ChangedFilesDetectorTest
 */
final class ChangedFilesDetector
{
    /**
     * @var string
     */
    private const CONFIGURATION_HASH_KEY = 'configuration_hash';
    /**
     * @var TagAwareAdapterInterface
     */
    private $tagAwareAdapter;
    /**
     * @var FileHashComputer
     */
    private $fileHashComputer;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Caching\Config\FileHashComputer $fileHashComputer, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface $tagAwareAdapter)
    {
        $this->tagAwareAdapter = $tagAwareAdapter;
        $this->fileHashComputer = $fileHashComputer;
    }
    /**
     * @param string[] $dependentFiles
     */
    public function addFileWithDependencies(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, array $dependentFiles) : void
    {
        $fileInfoCacheKey = $this->getFileInfoCacheKey($smartFileInfo);
        $hash = $this->hashFile($smartFileInfo);
        $this->saveItemWithValue($fileInfoCacheKey, $hash);
        $this->saveItemWithValue($fileInfoCacheKey . '_files', $dependentFiles);
    }
    public function hasFileChanged(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $currentFileHash = $this->hashFile($smartFileInfo);
        $fileInfoCacheKey = $this->getFileInfoCacheKey($smartFileInfo);
        $cacheItem = $this->tagAwareAdapter->getItem($fileInfoCacheKey);
        $oldFileHash = $cacheItem->get();
        return $currentFileHash !== $oldFileHash;
    }
    public function invalidateFile(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $fileInfoCacheKey = $this->getFileInfoCacheKey($smartFileInfo);
        $this->tagAwareAdapter->deleteItem($fileInfoCacheKey);
    }
    public function clear() : void
    {
        $this->tagAwareAdapter->clear();
    }
    /**
     * @return SmartFileInfo[]
     */
    public function getDependentFileInfos(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : array
    {
        $fileInfoCacheKey = $this->getFileInfoCacheKey($fileInfo);
        $cacheItem = $this->tagAwareAdapter->getItem($fileInfoCacheKey . '_files');
        if ($cacheItem->get() === null) {
            return [];
        }
        $dependentFileInfos = [];
        $dependentFiles = $cacheItem->get();
        foreach ($dependentFiles as $dependentFile) {
            if (!\file_exists($dependentFile)) {
                continue;
            }
            $dependentFileInfos[] = new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo($dependentFile);
        }
        return $dependentFileInfos;
    }
    /**
     * @api
     */
    public function setFirstResolvedConfigFileInfo(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        // the first config is core to all → if it was changed, just invalidate it
        $configHash = $this->fileHashComputer->compute($fileInfo);
        $this->storeConfigurationDataHash($fileInfo, $configHash);
    }
    private function getFileInfoCacheKey(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        return \sha1($smartFileInfo->getRealPath());
    }
    private function hashFile(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        return (string) \sha1_file($smartFileInfo->getRealPath());
    }
    /**
     * @param mixed $value
     */
    private function saveItemWithValue(string $key, $value) : void
    {
        $cacheItem = $this->tagAwareAdapter->getItem($key);
        $cacheItem->set($value);
        $this->tagAwareAdapter->save($cacheItem);
    }
    private function storeConfigurationDataHash(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $configurationHash) : void
    {
        $key = self::CONFIGURATION_HASH_KEY . '_' . \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::webalize($fileInfo->getRealPath());
        $this->invalidateCacheIfConfigurationChanged($key, $configurationHash);
        $this->saveItemWithValue($key, $configurationHash);
    }
    private function invalidateCacheIfConfigurationChanged(string $key, string $configurationHash) : void
    {
        $cacheItem = $this->tagAwareAdapter->getItem($key);
        $oldConfigurationHash = $cacheItem->get();
        if ($configurationHash !== $oldConfigurationHash) {
            // should be unique per getcwd()
            $this->clear();
        }
    }
}
