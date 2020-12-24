<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Analyser\ResultCache;

interface ResultCacheManagerFactory
{
    /**
     * @param array<string, string> $fileReplacements
     * @return ResultCacheManager
     */
    public function create(array $fileReplacements) : \_PhpScopere8e811afab72\PHPStan\Analyser\ResultCache\ResultCacheManager;
}
