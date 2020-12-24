<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Laravel\Tests\Rector\StaticCall\MinutesToSecondsInCacheRector\Source;

use _PhpScoperb75b35f52b74\Illuminate\Contracts\Cache\Store;
final class ArrayStore implements \_PhpScoperb75b35f52b74\Illuminate\Contracts\Cache\Store
{
    public function get($key)
    {
    }
    public function many(array $keys)
    {
    }
    public function put($key, $value, $seconds)
    {
    }
    public function putMany(array $values, $seconds)
    {
    }
    public function increment($key, $value = 1)
    {
    }
    public function decrement($key, $value = 1)
    {
    }
    public function forever($key, $value)
    {
    }
    public function forget($key)
    {
    }
    public function flush()
    {
    }
    public function getPrefix()
    {
    }
}
