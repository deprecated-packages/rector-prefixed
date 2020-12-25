<?php

declare (strict_types=1);
namespace _PhpScoper5edc98a7cce2\Doctrine\Inflector;

class NoopWordInflector implements \_PhpScoper5edc98a7cce2\Doctrine\Inflector\WordInflector
{
    public function inflect(string $word) : string
    {
        return $word;
    }
}
