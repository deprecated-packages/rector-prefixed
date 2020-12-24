<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Cache;

interface CacheStorage
{
    /**
     * @param string $key
     * @param string $variableKey
     * @return mixed|null
     */
    public function load(string $key, string $variableKey);
    /**
     * @param string $key
     * @param string $variableKey
     * @param mixed $data
     * @return void
     */
    public function save(string $key, string $variableKey, $data) : void;
}
