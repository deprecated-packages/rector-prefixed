<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Analyser\ResultCache;

interface ResultCacheManagerFactory
{
    /**
     * @param array<string, string> $fileReplacements
     * @return ResultCacheManager
     */
    public function create(array $fileReplacements) : \RectorPrefix20201227\PHPStan\Analyser\ResultCache\ResultCacheManager;
}
