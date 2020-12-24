<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Analyser\ResultCache;

interface ResultCacheManagerFactory
{
    /**
     * @param array<string, string> $fileReplacements
     * @return ResultCacheManager
     */
    public function create(array $fileReplacements) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\ResultCache\ResultCacheManager;
}
