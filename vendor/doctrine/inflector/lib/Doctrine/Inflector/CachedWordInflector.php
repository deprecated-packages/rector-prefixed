<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Doctrine\Inflector;

class CachedWordInflector implements \_PhpScoperb75b35f52b74\Doctrine\Inflector\WordInflector
{
    /** @var WordInflector */
    private $wordInflector;
    /** @var string[] */
    private $cache = [];
    public function __construct(\_PhpScoperb75b35f52b74\Doctrine\Inflector\WordInflector $wordInflector)
    {
        $this->wordInflector = $wordInflector;
    }
    public function inflect(string $word) : string
    {
        return $this->cache[$word] ?? ($this->cache[$word] = $this->wordInflector->inflect($word));
    }
}
