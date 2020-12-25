<?php

declare (strict_types=1);
namespace _PhpScoper17db12703726\Doctrine\Inflector;

class NoopWordInflector implements \_PhpScoper17db12703726\Doctrine\Inflector\WordInflector
{
    public function inflect(string $word) : string
    {
        return $word;
    }
}
