<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Doctrine\Inflector;

class CachedWordInflector implements \_PhpScoper88fe6e0ad041\Doctrine\Inflector\WordInflector
{
    /** @var WordInflector */
    private $wordInflector;
    /** @var string[] */
    private $cache = [];
    public function __construct(\_PhpScoper88fe6e0ad041\Doctrine\Inflector\WordInflector $wordInflector)
    {
        $this->wordInflector = $wordInflector;
    }
    public function inflect(string $word) : string
    {
        return $this->cache[$word] ?? ($this->cache[$word] = $this->wordInflector->inflect($word));
    }
}