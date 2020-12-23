<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Analyser\ResultCache;

interface ResultCacheManagerFactory
{
    /**
     * @param array<string, string> $fileReplacements
     * @return ResultCacheManager
     */
    public function create(array $fileReplacements) : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\ResultCache\ResultCacheManager;
}
