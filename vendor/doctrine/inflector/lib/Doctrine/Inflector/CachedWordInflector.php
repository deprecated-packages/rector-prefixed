<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32\Doctrine\Inflector;

class CachedWordInflector implements \_PhpScoper8b9c402c5f32\Doctrine\Inflector\WordInflector
{
    /** @var WordInflector */
    private $wordInflector;
    /** @var string[] */
    private $cache = [];
    public function __construct(\_PhpScoper8b9c402c5f32\Doctrine\Inflector\WordInflector $wordInflector)
    {
        $this->wordInflector = $wordInflector;
    }
    public function inflect(string $word) : string
    {
        return $this->cache[$word] ?? ($this->cache[$word] = $this->wordInflector->inflect($word));
    }
}
