<?php

declare (strict_types=1);
namespace Rector\Caching\Detector;

use RectorPrefix20210422\Nette\Caching\Cache;
use RectorPrefix20210422\Nette\Utils\Strings;
use Rector\Caching\Config\FileHashComputer;
use RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Inspired by https://github.com/symplify/symplify/pull/90/files#diff-72041b2e1029a08930e13d79d298ef11
 * @see \Rector\Caching\Tests\Detector\ChangedFilesDetectorTest
 */
final class ChangedFilesDetector
{
    /**
     * @var string
     */
    const CONFIGURATION_HASH_KEY = 'configuration_hash';
    /**
     * @var FileHashComputer
     */
    private $fileHashComputer;
    /**
     * @var Cache
     */
    private $cache;
    public function __construct(\Rector\Caching\Config\FileHashComputer $fileHashComputer, \RectorPrefix20210422\Nette\Caching\Cache $cache)
    {
        $this->fileHashComputer = $fileHashComputer;
        $this->cache = $cache;
    }
    /**
     * @param string[] $dependentFiles
     * @return void
     */
    public function addFileWithDependencies(\RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, array $dependentFiles)
    {
        $fileInfoCacheKey = $this->getFileInfoCacheKey($smartFileInfo);
        $hash = $this->hashFile($smartFileInfo);
        $this->cache->save($fileInfoCacheKey, $hash);
        $this->cache->save($fileInfoCacheKey . '_files', $dependentFiles);
    }
    public function hasFileChanged(\RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $currentFileHash = $this->hashFile($smartFileInfo);
        $fileInfoCacheKey = $this->getFileInfoCacheKey($smartFileInfo);
        $cachedValue = $this->cache->load($fileInfoCacheKey);
        return $currentFileHash !== $cachedValue;
    }
    /**
     * @return void
     */
    public function invalidateFile(\RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo)
    {
        $fileInfoCacheKey = $this->getFileInfoCacheKey($smartFileInfo);
        $this->cache->remove($fileInfoCacheKey);
    }
    /**
     * @return void
     */
    public function clear()
    {
        $this->cache->clean([\RectorPrefix20210422\Nette\Caching\Cache::ALL => \true]);
    }
    /**
     * @return SmartFileInfo[]
     */
    public function getDependentFileInfos(\RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : array
    {
        $fileInfoCacheKey = $this->getFileInfoCacheKey($fileInfo);
        $cacheValue = $this->cache->load($fileInfoCacheKey . '_files');
        if ($cacheValue === null) {
            return [];
        }
        $dependentFileInfos = [];
        $dependentFiles = $cacheValue;
        foreach ($dependentFiles as $dependentFile) {
            if (!\file_exists($dependentFile)) {
                continue;
            }
            $dependentFileInfos[] = new \RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo($dependentFile);
        }
        return $dependentFileInfos;
    }
    /**
     * @api
     * @return void
     */
    public function setFirstResolvedConfigFileInfo(\RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo $fileInfo)
    {
        // the first config is core to all → if it was changed, just invalidate it
        $configHash = $this->fileHashComputer->compute($fileInfo);
        $this->storeConfigurationDataHash($fileInfo, $configHash);
    }
    private function getFileInfoCacheKey(\RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        return \sha1($smartFileInfo->getRealPath());
    }
    private function hashFile(\RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        return (string) \sha1_file($smartFileInfo->getRealPath());
    }
    /**
     * @return void
     */
    private function storeConfigurationDataHash(\RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $configurationHash)
    {
        $key = self::CONFIGURATION_HASH_KEY . '_' . \RectorPrefix20210422\Nette\Utils\Strings::webalize($fileInfo->getRealPath());
        $this->invalidateCacheIfConfigurationChanged($key, $configurationHash);
        $this->cache->save($key, $configurationHash);
    }
    /**
     * @return void
     */
    private function invalidateCacheIfConfigurationChanged(string $key, string $configurationHash)
    {
        $oldCachedValue = $this->cache->load($key);
        if ($oldCachedValue === $configurationHash) {
            return;
        }
        // should be unique per getcwd()
        $this->clear();
    }
}
