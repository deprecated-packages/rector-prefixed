<?php

declare (strict_types=1);
namespace RectorPrefix20210317\Doctrine\Inflector;

class CachedWordInflector implements \RectorPrefix20210317\Doctrine\Inflector\WordInflector
{
    /** @var WordInflector */
    private $wordInflector;
    /** @var string[] */
    private $cache = [];
    /**
     * @param \Doctrine\Inflector\WordInflector $wordInflector
     */
    public function __construct($wordInflector)
    {
        $this->wordInflector = $wordInflector;
    }
    public function inflect(string $word) : string
    {
        return $this->cache[$word] ?? ($this->cache[$word] = $this->wordInflector->inflect($word));
    }
}
