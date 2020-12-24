<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Analyser\ResultCache;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Symfony\Component\Finder\Finder;
class ResultCacheClearer
{
    /** @var string */
    private $cacheFilePath;
    /** @var string */
    private $tempResultCachePath;
    public function __construct(string $cacheFilePath, string $tempResultCachePath)
    {
        $this->cacheFilePath = $cacheFilePath;
        $this->tempResultCachePath = $tempResultCachePath;
    }
    public function clear() : string
    {
        $dir = \dirname($this->cacheFilePath);
        if (!\is_file($this->cacheFilePath)) {
            return $dir;
        }
        @\unlink($this->cacheFilePath);
        return $dir;
    }
    public function clearTemporaryCaches() : void
    {
        $finder = new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Symfony\Component\Finder\Finder();
        foreach ($finder->files()->name('*.php')->in($this->tempResultCachePath) as $tmpResultCacheFile) {
            @\unlink($tmpResultCacheFile->getPathname());
        }
    }
}
