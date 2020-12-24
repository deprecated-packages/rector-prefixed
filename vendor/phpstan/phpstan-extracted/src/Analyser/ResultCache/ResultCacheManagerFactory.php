<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Analyser\ResultCache;

interface ResultCacheManagerFactory
{
    /**
     * @param array<string, string> $fileReplacements
     * @return ResultCacheManager
     */
    public function create(array $fileReplacements) : \_PhpScoperb75b35f52b74\PHPStan\Analyser\ResultCache\ResultCacheManager;
}
