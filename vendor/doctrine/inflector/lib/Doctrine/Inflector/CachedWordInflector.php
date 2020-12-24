<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Doctrine\Inflector;

class CachedWordInflector implements \_PhpScopere8e811afab72\Doctrine\Inflector\WordInflector
{
    /** @var WordInflector */
    private $wordInflector;
    /** @var string[] */
    private $cache = [];
    public function __construct(\_PhpScopere8e811afab72\Doctrine\Inflector\WordInflector $wordInflector)
    {
        $this->wordInflector = $wordInflector;
    }
    public function inflect(string $word) : string
    {
        return $this->cache[$word] ?? ($this->cache[$word] = $this->wordInflector->inflect($word));
    }
}
